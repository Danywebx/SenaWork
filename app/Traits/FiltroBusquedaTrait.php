<?php

namespace App\Traits;

use App\Models\Empleo;
use App\Models\User;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;

trait FiltroBusquedaTrait
{
    public function filtroInvitado($request)
    {
        $query = $request->input('query');
        $categoria = $request->input('categoria');

        $categorias = Categoria::all();
        $empleos = Empleo::where('estado', 1);


        if (!empty($query)) {
            $empleos->where('nombre', 'like', '%' . $query . '%')
                ->orWhere('descripcion', 'like', '%' . $query . '%');
            // ->orWhere('ubicacion', 'like', '%' . $query . '%');
        }

        if (!empty($categoria)) {
            $empleos->where('categoria_id', $categoria);
        }

        $empleos = $empleos->get();

        return compact('categorias', 'empleos');
    }


    public function filtrarEmpleos($request)
    {
        $query = $request->input('query');
        $categoria = $request->input('categoria');
        $userId = Auth::user()->id;

        $categorias = Categoria::all();
        $empleos = Empleo::where('usuario_id', '!=', $userId)
            ->where('estado_empleo', 'Publicado')
            ->where('estado', 1);


        if (!empty($query)) {
            $empleos->where('nombre', 'like', '%' . $query . '%')
                ->orWhere('descripcion', 'like', '%' . $query . '%');
            // ->orWhere('ubicacion', 'like', '%' . $query . '%');
        }

        if (!empty($categoria)) {
            $empleos->where('categoria_id', $categoria);
        }

        $empleos = $empleos->get();

        return compact('categorias', 'empleos');
    }


    public function filtrarPostulaciones($request, $postulaciones)
    {
        $categoria = $request->input('categoria');
        $orden = $request->input('orden');

        if (!empty($categoria)) {
            $postulaciones = $postulaciones->filter(function ($postulacion) use ($categoria) {
                return $postulacion->empleo->categoria_id == $categoria;
            });
        }

        switch ($orden) {
            case 'az':
                $postulaciones = $postulaciones->sortBy(function ($postulacion) {
                    return $postulacion->empleo->nombre;
                });
                break;
            case 'za':
                $postulaciones = $postulaciones->sortByDesc(function ($postulacion) {
                    return $postulacion->empleo->nombre;
                });
                break;
            case 'estado':
                $postulaciones = $postulaciones->sortBy(function ($postulacion) {
                    $estadoMap = [
                        'Seleccionado' => 1,
                        'En espera' => 2,
                        'Realizado' => 3,
                        'No seleccionado' => 4,
                        'Cancelado' => 5
                    ];
                    return $estadoMap[$postulacion->estado_postulacion] ?? 6;
                });
                break;
            case 'antigua':
                $postulaciones = $postulaciones->sortBy(function ($postulacion) {
                    return $postulacion->fecha_inicio;
                });
                break;
            case 'reciente':
                $postulaciones = $postulaciones->sortByDesc(function ($postulacion) {
                    return $postulacion->fecha_inicio;
                });
                break;
        }

        $categorias = Categoria::all();

        return compact('categorias', 'postulaciones');
    }


    public function filtrarMisEmpleos($request)
    {
        $categoria = $request->input('categoria');
        $orden = $request->input('orden');
        $userId = Auth::user()->id;

        $empleos = Empleo::where('usuario_id', $userId);

        if (!empty($categoria)) {
            $empleos->where('categoria_id', $categoria);
        }

        switch ($orden) {
            case 'az':
                $empleos->orderBy('nombre', 'asc');
                break;
            case 'za':
                $empleos->orderBy('nombre', 'desc');
                break;
            case 'estado':
                $empleos->orderByRaw("
                    CASE 
                        WHEN estado_empleo = 'En proceso' THEN 1
                        WHEN estado_empleo = 'Publicado' THEN 2
                        WHEN estado_empleo = 'Finalizado' THEN 3
                        WHEN estado_empleo = 'Eliminado' THEN 4
                        ELSE 5
                    END
                ");
                break;
            case 'antigua':
                $empleos->orderBy('fecha_creacion', 'asc');
                break;
            case 'reciente':
                $empleos->orderBy('fecha_creacion', 'desc');
                break;
        }

        $empleos = $empleos->get();

        $categorias = Categoria::all();

        return compact('categorias', 'empleos');
    }


    public function filtrarUsuarios($request)
    {
        $query = $request->input('query');
        $categoria = $request->input('categoria');
        $userId = Auth::user()->id;

        $usuarios = User::where('id', '!=', $userId)
            ->where('estado', 1)
            ->where('estado_perfil', 1)
            ->with('categoria');

        if (!empty($query)) {
            $usuarios->where(function ($q) use ($query) {
                $q->where('nombre', 'like', '%' . $query . '%')
                    ->orWhere('apellido', 'like', '%' . $query . '%')
                    ->orWhere('s_nombre', 'like', '%' . $query . '%')
                    ->orWhere('s_apellido', 'like', '%' . $query . '%');
            });
        }

        if (!empty($categoria)) {
            $usuarios->where('categoria_id', $categoria);
        }

        $usuarios = $usuarios->get();

        $categorias = Categoria::all();

        return compact('categorias', 'usuarios');
    }
}
