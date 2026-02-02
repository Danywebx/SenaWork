<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Empleo;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EmpleoController extends Controller
{
    public function verificarDocumentosCompletos()
    {
        $usuario = Auth::user();
        $documentosRequeridos = ['documento_identidad', 'antecedentes_judiciales', 'portafolio'];
        $documentosSubidos = $usuario->documentos->whereIn('tipo', $documentosRequeridos)->pluck('tipo')->toArray();

        return count(array_diff($documentosRequeridos, $documentosSubidos)) === 0;
    }




    public function index()
    {
        if (!$this->verificarDocumentosCompletos()) {
            return redirect()->route('perfil')->with('error', 'Debes completar tu perfil.');
        } else {

            $categorias = Categoria::all();
            return view('Empleador/crear_empleo', compact('categorias',));
        }
    }




    public function publicarEmpleo(Request $request)
    {

        // dd($request->file('fotos'));

        if (!$this->verificarDocumentosCompletos()) {
            return redirect()->route('perfil')->with('error', 'Debes completar tu perfil.');
        } else {

            $request->validate([
                'nombre_empleo' => 'required|string|max:150',
                'categoria' => 'required',
                'ubicacion' => 'required|string|max:100',
                'fotos' => 'array|max:3',
                'fotos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',  // Limita el tipo de archivo a imágenes y el tamaño a 2MB
                'descripcion' => 'required|string|max:500',
            ]);


            $fotos_paths = [];
            if ($request->hasFile('fotos')) {
                foreach ($request->file('fotos') as $foto) {
                    $path = $foto->store('public/fotos');
                    $fotos_paths[] = $path;
                }
            }


            $fotos_json = json_encode($fotos_paths);

            $empleo = new Empleo();
            $empleo->nombre = $request->input('nombre_empleo');
            $empleo->descripcion = $request->input('descripcion');
            $empleo->fotos = $fotos_json;
            $empleo->ubicacion = $request->input('ubicacion');
            $empleo->categoria_id = $request->input('categoria');
            $empleo->usuario_id = Auth::id();
            $empleo->fecha_creacion = Carbon::now();
            $empleo->fecha_cierre = Carbon::now()->addDays(15);
            $empleo->save();

            Storage::disk('local')->put('public/fotos.json', $fotos_json);
            return redirect()->route('mis.empleos')->with('success', 'Empleo creado exitosamente');
        }
    }




    public function reportarEmpleo(Request $request, $empleo_id)
    {
        $request->validate([
            'tipo_reporte' => 'required|string|max:100',
            'motivo' => 'required|string|max:100',
            'comentario' => 'required|string|max:2000',
        ]);

        $empleo = Empleo::findOrFail($empleo_id);

        $reporte = new Reporte();
        $reporte->tipo_reporte = 'Empleo';
        $reporte->motivo = $request->motivo;
        $reporte->comentario = $request->comentario;
        $reporte->fecha_reporte = now();
        $reporte->notificador_id = Auth::user()->id;
        $reporte->notificado_id = $empleo->usuario_id;
        $reporte->empleo_id = $empleo_id;

        $reporte->save();

        return redirect()->back()->with('success', 'El reporte se ha enviado correctamente.');
    }


    

    public function verificarEstadosEmpleos()
    {
        $empleos = Empleo::where('estado', 1)
            ->where('fecha_cierre', '<', Carbon::now())
            ->get();

        foreach ($empleos as $empleo) {
            $empleo->estado = 0;
            $empleo->save();
        }
    }
}
