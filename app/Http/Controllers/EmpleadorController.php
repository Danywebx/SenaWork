<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Documento;
use App\Models\Empleo;
use App\Models\Postulacion;
use App\Models\Reporte;
use App\Models\User;
use App\Traits\FiltroBusquedaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmpleadorController extends Controller
{
    use FiltroBusquedaTrait;


    public function verificarDocumentosCompletos()
    {
        $usuario = Auth::user();
        $documentosRequeridos = ['documento_identidad', 'antecedentes_judiciales', 'portafolio'];
        $documentosSubidos = $usuario->documentos->whereIn('tipo', $documentosRequeridos)->pluck('tipo')->toArray();

        return count(array_diff($documentosRequeridos, $documentosSubidos)) === 0;
    }




    public function index(Request $request)
    {
        $documentosCompletos = $this->verificarDocumentosCompletos();
        $categorias = Categoria::all();
        $data = $this->filtrarUsuarios($request);


        $usuarios = User::where('estado_perfil', 1)
            ->where('estado', 1)
            ->where('id', '!=', Auth::user()->id)
            ->get();

        return view('Empleador/index',  $data, compact('categorias',  'usuarios', 'documentosCompletos'));
    }




    public function misEmpleos(Request $request)
    {
        if (!$this->verificarDocumentosCompletos()) {
            return redirect()->route('perfil')->with('error', 'Debes completar tu perfil subiendo los documentos.');
        }

        $userId = Auth::user()->id;
        $empleos = Empleo::where('usuario_id', $userId)->get();

        $empleoIds = $empleos->pluck('id');


        $postulacionesEnEspera = [];

        foreach ($empleos as $empleo) {
            $postulacionesEnEspera[$empleo->id] = $empleo->postulaciones()
                ->where('estado_postulacion', 'En espera')
                ->get();
        }

        $data = $this->filtrarMisEmpleos($request, $empleos);

        return view('Empleador/empleos', $data, compact('empleos', 'postulacionesEnEspera'));
    }




    public function reportarUsuario(Request $request, $empleo_id)
    {
        $request->validate([
            'motivo' => 'required|string|max:100',
            'comentario' => 'required|string|max:2000',
        ]);

        $postulacionSeleccionada = Postulacion::where('empleo_id', $empleo_id)
            ->where('estado_postulacion', 'Seleccionado')
            ->first();

        if (!$postulacionSeleccionada) {
            return redirect()->back()->with('error', 'No hay un usuario seleccionado para este empleo.');
        }

        $reporte = new Reporte();
        $reporte->tipo_reporte = 'Usuario';
        $reporte->motivo = $request->motivo;
        $reporte->comentario = $request->comentario;
        $reporte->notificador_id = Auth::user()->id;
        $reporte->notificado_id = $postulacionSeleccionada->usuario_id;
        $reporte->empleo_id = $empleo_id;
        $reporte->fecha_reporte = now();

        $reporte->save();

        return redirect()->back()->with('success', 'El reporte se ha enviado correctamente.');
    }




    public function descargarPortafolio($usuario_id)
    {
        $documento = Documento::where('usuario_id', $usuario_id)
            ->where('tipo', 'portafolio')
            ->first();

        if ($documento && Storage::exists($documento->ruta)) {
            return response()->download(storage_path('app/' . $documento->ruta));
        } else {
            return redirect()->back()->with('error', 'El portafolio no está disponible.');
        }
    }




    public function seleccionarPostulado($id)
    {
        $postulacionSeleccionada = Postulacion::find($id);

        if ($postulacionSeleccionada) {
            $postulacionSeleccionada->estado_postulacion = 'Seleccionado';
            $postulacionSeleccionada->save();

            Postulacion::where('empleo_id', $postulacionSeleccionada->empleo_id)
                ->where('id', '!=', $postulacionSeleccionada->id)
                ->update(['estado_postulacion' => 'No seleccionado']);

            $empleo = Empleo::find($postulacionSeleccionada->empleo_id);
            $empleo->estado_empleo = 'En proceso';
            $empleo->save();
        }

        return back()->with('success', 'Postulado seleccionado exitosamente.');
    }




    public function rechazarPostulado($id)
    {
        $postulacion = Postulacion::find($id);
        if ($postulacion) {
            $postulacion->estado_postulacion = 'No Seleccionado';
            $postulacion->save();
        }
        return back()->with('success', 'Postulado rechazado.');
    }




    public function finalizarEmpleo(Request $request, $empleo_id)
    {
        $empleo = Empleo::findOrFail($empleo_id);

        if ($empleo->estado_empleo !== 'En proceso') {
            return redirect()->back()->with('error', 'Este empleo no se puede finalizar.');
        }

        session()->put('show_rating_popup', true);
        session()->put('empleo_id', $empleo_id);

        return redirect()->back();
    }



    public function guardarCalificacion(Request $request, $empleo_id)
    {
        $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:2000',
        ]);

        $empleo = Empleo::findOrFail($empleo_id);

        $empleo->estado_empleo = 'Finalizado';
        $empleo->fecha_cierre = now();
        $empleo->save();

        $postulacion = Postulacion::where('empleo_id', $empleo_id)
            ->where('estado_postulacion', 'Seleccionado')
            ->firstOrFail();

        $postulacion->estado_postulacion = 'Realizado';
        $postulacion->puntuacion_empleado = $request->input('calificacion');
        $postulacion->comentario_empleado = $request->input('comentario');
        $postulacion->fecha_cierre = now();
        $postulacion->save();

        return redirect()->route('mis.empleos')
            ->with('success', 'Empleo finalizado y calificación guardada correctamente.');
    }




    public function eliminarEmpleo($id)
    {
        $empleo = Empleo::findOrFail($id);

        if (Auth::user()->id == $empleo->usuario_id && $empleo->estado_empleo == 'Publicado') {
            $empleo->estado = 0;
            $empleo->estado_empleo = "Eliminado";
            $empleo->save();

            $postulaciones = Postulacion::where('empleo_id', $id)->where('estado_postulacion', 'En espera')->get();

            foreach ($postulaciones as $postulacion) {
                $postulacion->estado_postulacion = 'No seleccionado';
                $postulacion->save();
            }

            return redirect()->route('mis.empleos')->with('success', 'El empleo ha sido eliminado.');
        } else {
            return redirect()->route('mis.empleos')->with('error', 'No puedes eliminar este empleo.');
        }
    }
}
