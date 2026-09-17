<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['id' => 1, 
            'nombre' => 'Test',
            'apellido' => 'Rol',
            's_apellido' => 'User',
            't_documento' => 'Cédula de ciudadanía',
            'n_documento' => 1234567890,
            'fecha_nacimiento' => '2000-10-26',
            'telefono' => '3005489612',
            'direccion' => 'Calle lejos',
            'correo' => 'test@gmail.com',
            'contrasena' => '12345678',
            'rol_id' => 2,
            'categoria_id' => 15,            
            ],
            ['id' => 2, 
            'nombre' => 'Test',
            'apellido' => 'Delete',
            's_apellido' => 'User',
            't_documento' => 'Cédula de ciudadanía',
            'n_documento' => 10987654321,
            'fecha_nacimiento' => '2000-10-27',
            'telefono' => '3008549672',
            'direccion' => 'Calle cerca',
            'correo' => 'test_user_delete@gmail.com',
            'contrasena' => '12345678',
            'rol_id' => 2,
            'categoria_id' => 15,            
            ],         
            ['id' => 3, 
            'nombre' => 'Test',
            's_nombre' => 'Change',
            'apellido' => 'Password',
            's_apellido' => 'User',
            't_documento' => 'Cédula de ciudadanía',
            'n_documento' => 2468101214,
            'fecha_nacimiento' => '2000-10-28',
            'telefono' => '3006759843',
            'direccion' => 'Calle capáz',
            'correo' => 'test_user_contrasenas@gmail.com',
            'contrasena' => '12345678',
            'rol_id' => 2,
            'categoria_id' => 15,            
            ],         
        ];

        foreach ($users as $user) {
            DB::table('usuarios')->updateOrInsert(
                ['id' => $user['id']],
                [
                    'nombre' => $user['nombre'],
                    'apellido' => $user['apellido'],
                    's_apellido' => $user['s_apellido'],
                    't_documento' => $user['t_documento'],
                    'n_documento' => $user['n_documento'],
                    'fecha_nacimiento' => $user['fecha_nacimiento'],
                    'telefono' => $user['telefono'],
                    'direccion' => $user['direccion'],
                    'correo' => $user['correo'],
                    'contrasena' => Hash::make($user['contrasena']),
                    'rol_id' => $user['rol_id'],
                    'categoria_id' => $user['categoria_id'],
                ]
            );
        }
    }
}
