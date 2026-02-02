<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Empleo;
use App\Models\Postulacion;
use App\Models\User;

class AuthController extends Controller
{
    public function registerForm()
    {
        $categorias = Categoria::all();
        return view('register', compact('categorias'));
    }


    public function register(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'nombres' => 'required|string|max:60',
            'apellidos' => 'required|string|max:60',
            'tipo_documento' => 'required|string|max:30',
            'numero_documento' => 'required|numeric|digits_between:9,10|unique:usuarios,n_documento',
            'fecha_nacimiento' => ['required', 'date', function ($attribute, $value, $fail) {
                $age = \Carbon\Carbon::parse($value)->age;
                if ($age < 18) {
                    $fail('Debes tener al menos 18 años para registrarte.');
                }
                if ($age > 100) {
                    $fail('No puedes tener más de 100 años para registrarte.');
                }
            }],
            'celular' => 'required|numeric|digits:10',
            'direccion' => 'required|string|max:75',
            'email' => 'required|string|email|max:150|unique:usuarios,correo',
            'password' => 'required|string|min:8|max:1000|confirmed',
            'rol' => 'required|in:2,3',
            'categoria' => 'required',
            'terms' => 'accepted',
        ]);

        //Concatenar y dividir el nombre completo
        $nombres = explode(' ', trim($request->input('nombres')));
        $nombre = $nombres[0];
        $s_nombre = isset($nombres[1]) ? implode(' ', array_slice($nombres, 1)) : null;

        $apellidos = explode(' ', trim($request->input('apellidos')));
        if (count($apellidos) < 2) {
            return back()->withErrors(['apellidos' => 'Debe ingresar al menos dos apellidos.'])->withInput();
        }
        $apellido = $apellidos[0];
        $s_apellido = implode(' ', array_slice($apellidos, 1));


        $usuario = new User();
        $usuario->nombre = $nombre;
        $usuario->s_nombre = $s_nombre;
        $usuario->apellido = $apellido;
        $usuario->s_apellido = $s_apellido;
        $usuario->t_documento = $request->input('tipo_documento');
        $usuario->n_documento = $request->input('numero_documento');
        $usuario->fecha_nacimiento = $request->input('fecha_nacimiento');
        $usuario->telefono = $request->input('celular');
        $usuario->direccion = $request->input('direccion');
        $usuario->correo = $request->input('email');
        $usuario->contrasena = Hash::make($request->input('password'));
        $usuario->rol_id = $request->input('rol');
        $usuario->categoria_id = $request->input('categoria');
        $usuario->save();

        Auth::login($usuario);

        if ($usuario->rol_id == 2) {
            return redirect()->route('empleado');
        } elseif ($usuario->rol_id == 3) {
            return redirect()->route('empleador');
        }

        return redirect()->route('empleado');
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'correo' => $request->input('email'),
            'password' => $request->input('password')
        ];

        if (Auth::attempt(['correo' => $credentials['correo'], 'password' => $credentials['password']])) {
            $user = Auth::user();

            if ($user->estado == 0) {
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'password' => 'Tu cuenta ha sido desactivada. Contacta al soporte para más información.',
                ]);
            }

            if ($user->rol->nombre === 'Empleado') {
                return redirect()->route('empleado');
            } elseif ($user->rol->nombre === 'Empleador') {
                return redirect()->route('empleador');
            }
        } else {
            return redirect()->route('login')->withErrors([
                'password' => 'Credenciales incorrectas.',
            ]);
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('inicio'));
    }


    public function eliminarCuenta(Request $request)
    {
        $usuario = Auth::user();

        $usuario->estado = 0;
        $usuario->estado_perfil = 0;
        $usuario->save();

        Empleo::where('usuario_id', $usuario->id)
            ->update([
                'estado_empleo' => 'Eliminado',
                'estado' => 0
            ]);

        Postulacion::where('usuario_id', $usuario->id)
            ->update([
                'estado_postulacion' => 'Cancelado',
                'estado' => 0
            ]);

        Auth::logout();

        return redirect()->route('inicio')->with('status', 'Cuenta eliminada exitosamente.');
    }
}
