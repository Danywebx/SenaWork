<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['id' => 1, 'nombre' => 'User', 'estado' => 1],
            ['id' => 2, 'nombre' => 'Empleado', 'estado' => 1],
            ['id' => 3, 'nombre' => 'Empleador', 'estado' => 1],
            ['id' => 4, 'nombre' => 'Administrador', 'estado' => 1],
        ];

        foreach ($roles as $rol) {
            DB::table('roles')->updateOrInsert(
                ['id' => $rol['id']],
                [
                    'nombre' => $rol['nombre'],
                    'estado' => $rol['estado'],
                ]
            );
        }
    }
}
