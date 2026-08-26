<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['id' => 1,  'nombre' => 'Remodelación y construcción', 'estado' => 1],
            ['id' => 2,  'nombre' => 'Limpieza', 'estado' => 1],
            ['id' => 3,  'nombre' => 'Asistencia doméstica', 'estado' => 1],
            ['id' => 4,  'nombre' => 'Reparación e instalación de equipos', 'estado' => 1],
            ['id' => 5,  'nombre' => 'Taller de carro, moto o bicicleta', 'estado' => 1],
            ['id' => 6,  'nombre' => 'Maquinaria especial', 'estado' => 1],
            ['id' => 7,  'nombre' => 'Servicios profesionales', 'estado' => 1],
            ['id' => 8,  'nombre' => 'Servicios de belleza', 'estado' => 1],
            ['id' => 9,  'nombre' => 'Computadoras y TI', 'estado' => 1],
            ['id' => 10, 'nombre' => 'Cursos y clases', 'estado' => 1],
            ['id' => 11, 'nombre' => 'Organización de eventos', 'estado' => 1],
            ['id' => 12, 'nombre' => 'Servicios para mascotas', 'estado' => 1],
            ['id' => 13, 'nombre' => 'Servicios de electrónica', 'estado' => 1],
            ['id' => 14, 'nombre' => 'Mensajería y transporte', 'estado' => 1],
            ['id' => 15, 'nombre' => 'Otra', 'estado' => 1],
        ];

        foreach ($categorias as $categoria) {
            DB::table('categorias')->updateOrInsert(
                ['id' => $categoria['id']],
                [
                    'nombre' => $categoria['nombre'],
                    'estado' => $categoria['estado'],
                ]
            );
        }
    }
}
