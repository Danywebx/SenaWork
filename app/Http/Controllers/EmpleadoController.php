<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Empleo;
use App\Models\Postulacion;
use App\Models\Reporte;
use App\Traits\FiltroBusquedaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpleadoController extends Controller
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

        $data = $this->filtrarEmpleos($request);
        $categorias = Categoria::all();
        $empleos = Empleo::where('estado', 1)
            ->where('estado_empleo', 'Publicado')
            ->where('usuario_id', '!=', Auth::user()->id)
            ->get();

        return view('Empleado/index', $data, compact('categorias', 'empleos', 'documentosCompletos'));
    }


    public function cambiarEstadoPerfil(Request $request)
    {
        $request->validate([
            'estado_perfil' => 'required|boolean',
        ]);

        $usuario = Auth::user();
        $usuario->estado_perfil = $request->input('estado_perfil',);
        $usuario->save();

        return response()->json(['success' => true]);
    }


    public function aplicar(Request $request, $id)
    {
        if (!$this->verificarDocumentosCompletos()) {
            return redirect()->route('perfil')->with('error', 'Debes completar tu perfil subiendo los documentos.');
        } else {

            $usuario = Auth::user();

            $alreadyApplied = Postulacion::where('usuario_id', $usuario->id)
                ->where('empleo_id', $id)
                ->where('estado', 1)
                ->exists();

            if ($alreadyApplied) {
                return redirect()->back()->with('error', 'Ya has aplicado a este empleo.');
            }


            Postulacion::create([
                'usuario_id' => $usuario->id,
                'empleo_id' => $id,
                'fecha_inicio' => now(),
                'estado_postulacion' => 'En espera',
            ]);

            return redirect()->route('postulaciones')->with('success', 'Has aplicado al empleo exitosamente.');
        }
    }


    public function mostrarPostulaciones(Request $request)
    {
        if (!$this->verificarDocumentosCompletos()) {
            return redirect()->route('perfil')->with('error', 'Debes completar tu perfil subiendo los documentos.');
        }

        $usuarioId = Auth::user()->id;
        $postulaciones = Postulacion::with('empleo')
            ->where('usuario_id', $usuarioId)
            ->get();

        $data = $this->filtrarPostulaciones($request, $postulaciones);

        return view('Empleado/postulaciones', $data);
    }


    public function reportarUsuario(Request $request, $empleo_id)
    {
        $request->validate([
            'motivo' => 'required|string|max:100',
            'comentario' => 'required|string|max:2000',
        ]);

        $empleo = Empleo::findOrFail($empleo_id);

        $reporte = new Reporte();
        $reporte->tipo_reporte = 'Usuario';
        $reporte->motivo = $request->motivo;
        $reporte->comentario = $request->comentario;
        $reporte->notificador_id = Auth::user()->id;
        $reporte->notificado_id = $empleo->usuario_id;
        $reporte->empleo_id = $empleo->id;
        $reporte->fecha_reporte = now();
        $reporte->save();

        return redirect()->back()->with('success', 'El reporte se ha enviado correctamente.');
    }


    public function finalizarPostulacion(Request $request, $postulacion_id)
    {
        $postulacion = Postulacion::findOrFail($postulacion_id);

        if ($postulacion->estado_postulacion !== 'Seleccionado') {
            return redirect()->back()->with('error', 'Esta postulacion no se puede finalizar.');
        }

        session()->put('show_rating_popup', true);
        session()->put('postulacion_id', $postulacion_id);

        return redirect()->back();
    }



    public function guardarCalificacion(Request $request, $postulacion_id)
    {
        $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:2000',
        ]);


        $postulacion = Postulacion::where('id', $postulacion_id)
            ->where('estado_postulacion', 'Realizado')
            ->firstOrFail();

        $postulacion->puntuacion_empleador = $request->input('calificacion');
        $postulacion->comentario_empleador = $request->input('comentario');
        $postulacion->save();

        return redirect()->route('postulaciones')
            ->with('success', ' Calificación guardada correctamente.');
    }


    public function cancelarPostulacion($id)
    {
        $postulacion = Postulacion::find($id);

        if ($postulacion->estado_postulacion == 'En espera') {
            $postulacion->estado_postulacion = 'Cancelado';
            $postulacion->estado = 0;
            $postulacion->save();
            return redirect()->back()->with('success', 'Postulación cancelada exitosamente.');
        } else {
            return redirect()->back()->with('error', 'No se puede cancelar la postulación en este estado.');
        }
    }
}
