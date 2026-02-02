<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Empleo;
use App\Traits\FiltroBusquedaTrait;
use Illuminate\Http\Request;

class BusquedaController extends Controller
{
    use FiltroBusquedaTrait;


    public function index()
    {
        $categorias = Categoria::all();
        return view('index', compact('categorias'));
    }


    public function buscar(Request $request)
    {
        $data = $this->filtroInvitado($request);

        return view('invitado', $data);
    }

    // public function indexes(Request $request)
    // {
    //     $tipo = $request->input('tipo');
    //     $categoria = $request->input('categoria');

    //     if ($tipo == 'Empleos') {
    //         return redirect()->route('empleador', ['categoria' => $categoria]);
    //     } elseif ($tipo == 'Empleados') {
    //         return redirect()->route('empleado', ['categoria' => $categoria]);
    //     }
    // }
}
