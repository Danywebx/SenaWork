<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Documento;
use App\Models\Empleo;
use App\Models\Postulacion;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsuarioController extends Controller
{
    public function verificarDocumentosCompletos()
    {
        $usuario = Auth::user();
        $documentosRequeridos = ['documento_identidad', 'antecedentes_judiciales', 'portafolio'];
        $documentosSubidos = $usuario->documentos->whereIn('tipo', $documentosRequeridos)->pluck('tipo')->toArray();

        return count(array_diff($documentosRequeridos, $documentosSubidos)) === 0;
    }


    

    public function cambiarRol(Request $request)
    {
        if (!$this->verificarDocumentosCompletos()) {
            return redirect()->route('perfil')->with('error', 'Debes completar tu perfil subiendo los documentos.');
        }

        $usuario = Auth::user();

        $request->validate([
            'rol' => 'required|exists:roles,id',
        ]);

        $usuario->rol_id = $request->input('rol');
        $usuario->save();

        if ($usuario->rol_id == 2) {
            return redirect()->route('empleado');
        } elseif ($usuario->rol_id == 3) {
            return redirect()->route('empleador');
        }

        return redirect()->back()->with('error', 'Rol no válido');
    }




    public function perfil()
    {
        $documentosCompletos = $this->verificarDocumentosCompletos();
        $categorias = Categoria::all();

        $usuario = Auth::user();
        $categoria = $usuario->categoria;
        return view('perfil', compact('usuario', 'categoria', 'categorias', 'documentosCompletos'));
    }




    public function descargarMiPortafolio()
    {
        $usuario = Auth::user();

        $documento = Documento::where('usuario_id', $usuario->id)
            ->where('tipo', 'portafolio')
            ->first();

        if ($documento && Storage::exists($documento->ruta)) {
            return response()->download(storage_path('app/' . $documento->ruta));
        } else {
            return redirect()->back()->with('error', 'El portafolio no está disponible.');
        }
    }




    public function subirDocumentos(Request $request)
    {
        $usuario = Auth::user();

        $request->validate([
            'documento_identidad' => 'required|file|mimes:pdf|max:2048', // Máx 2MB por archivo
            'antecedentes_judiciales' => 'required|file|mimes:pdf|max:2048',
            'portafolio' => 'required|file|mimes:pdf|max:2048',
        ]);

        $documentos = [
            'documento_identidad' => $request->file('documento_identidad'),
            'antecedentes_judiciales' => $request->file('antecedentes_judiciales'),
            'portafolio' => $request->file('portafolio'),
        ];

        foreach ($documentos as $tipo => $archivo) {
            $ruta = $archivo->store('documentos');

            Documento::create([
                'tipo' => $tipo,
                'ruta' => $ruta,
                'usuario_id' => $usuario->id,
                'estado_doc' => 'Aprobado',
            ]);
        }

        return redirect()->route('perfil')->with('success', 'Documentos subidos correctamente.');
    }




    public function actualizarPerfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'celular' => 'required|numeric|digits:10',
            'categoria' => 'required',
            'portafolio' => 'nullable|mimes:pdf|max:2048', // Limita el archivo a PDF y tamaño de 2MB
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->telefono = $request->input('celular');
        $user->categoria_id = $request->input('categoria');
        $user->save();

        if ($request->hasFile('portafolio')) {
            $portafolio = Documento::where('usuario_id', $user->id)->where('tipo', 'portafolio')->first();

            if ($portafolio && Storage::exists($portafolio->ruta)) {
                Storage::delete($portafolio->ruta);
            }

            $rutaNueva = $request->file('portafolio')->store('documentos');

            if ($portafolio) {
                $portafolio->ruta = $rutaNueva;
                $portafolio->save();
            } else {
                Documento::create([
                    'tipo' => 'portafolio',
                    'ruta' => $rutaNueva,
                    'usuario_id' => $user->id,
                    'estado_doc' => 'activo',
                    'estado' => 1
                ]);
            }
        }

        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::exists($user->foto)) {
                Storage::delete($user->foto);
            }

            $rutaFoto = $request->file('foto')->store('fotos_perfil');
            $user->foto = $rutaFoto;
            $user->save();
        }

        return redirect()->back()->with('success', 'Perfil actualizado con éxito.');
    }




    public function eliminarFotoPerfil()
    {
        $user = Auth::user();

        if ($user->foto && Storage::exists($user->foto)) {
            Storage::delete($user->foto);
        }

        $user->foto = null;
        $user->save();

        return redirect()->back()->with('success', 'Foto de perfil eliminada.');
    }




    public function cambiarContrasena(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8',
            'newpassword' => 'required|string|min:8',
            'renewpassword' => 'required|string|same:newpassword'
        ], [
            'renewpassword.same' => 'La confirmación de la nueva contraseña no coincide.'
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->contrasena)) {
            return back()->withErrors(['password' => 'La contraseña actual es incorrecta.']);
        }

        if (Hash::check($request->newpassword, $user->contrasena)) {
            return back()->withErrors(['newpassword' => 'La nueva contraseña no puede ser la misma que la actual.']);
        }

        $user->contrasena = Hash::make($request->newpassword);
        $user->save();

        return back()->with('success', 'Tu contraseña ha sido actualizada correctamente.');
    }    




    public function invitado()
    {
        $categorias = Categoria::all();

        $empleos = Empleo::where('estado', 1)
            ->where('estado_empleo', 'Publicado')
            ->get();

        return view('invitado', compact('categorias', 'empleos'));
    }
}
