<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        /* 
            use Illuminate\Support\Facades\Hash;
            dd(Hash::make("password"));
        */


        // USUARIOS
        DB::table('users')->insert([
            'name' => 'El Juego Perfecto MX',
            'email' => 'eljuegoperfectomx13@gmail.com',
            'password' => '$2y$10$oIsnvXUi6DwR14GQzvBXmOFtX6.FeofhzyZ3sm4UsxnpXH0BMoH76',
        ]);

        /* DB::table('users')->insert([
            'name' => 'Jesús Herrera',
            'email' => 'jesusherrera13@gmail.com',
            'password' => '$2y$10$oIsnvXUi6DwR14GQzvBXmOFtX6.FeofhzyZ3sm4UsxnpXH0BMoH76',
        ]); */

        /* 
        DB::table('users')->insert([
            'name' => 'Luis Franco',
            'email' => 'luisfran301@hotmail.com',
            'password' => '$2y$10$/zDSyAUi.9iGHJ.6NJlBluL0qK2MHxd5.UzVwU0pMO2VJvb.T26RG',
        ]); 
        */

        // ADMINISTRADORES DE SISTEMA
        DB::table('system_administradores')->insert([
            'user_id' => 1,
            'created_at' => date('Y-m-d h:i:s')
        ]);

        DB::table('system_roles')->insert([
            'nombre' => 'Administrador',
            'created_at' => date('Y-m-d h:i:s')
        ]);

        DB::table('system_roles')->insert([
            'nombre' => 'Propietario',
            'created_at' => date('Y-m-d h:i:s')
        ]);

        DB::table('system_roles')->insert([
            'nombre' => 'Usuario',
            'created_at' => date('Y-m-d h:i:s')
        ]);

        DB::table('system_roles')->insert([
            'nombre' => 'Invitado',
            'created_at' => date('Y-m-d h:i:s')
        ]);
        // ROLES

        // USER ROL
        DB::table('users_roles')->insert([
            'user_id' => 1,
            'rol_id' => 1,
            'created_at' => date('Y-m-d h:i:s')
        ]);
        // USER ROL

        // MODULOS
        DB::table('system_modulos')->insert([
            'nombre' => 'Configuración',
            'key' => 'system-configuracion',
            'route' => '/system-configuracion',
            'mdi_icon' => 'mdi-cog',
            'created_at' => date('Y-m-d h:i:s'),
        ]);
        // MODULOS


        // MENUS
        DB::table('system_modulos_menus')->insert([
            'nombre' => 'Módulos',
            'key' => 'system-modulos',
            'route' => '/system-modulos',
            'mdi_icon' => 'mdi-view-grid',
            'created_at' => date('Y-m-d h:i:s'),
            'modulo_id' => 1
        ]);

        DB::table('system_modulos_menus')->insert([
            'nombre' => 'Usuarios',
            'key' => 'system-usuarios',
            'route' => '/system-usuarios',
            'mdi_icon' => 'mdi-account-multiple',
            'created_at' => date('Y-m-d h:i:s'),
            'modulo_id' => 1
        ]);

        DB::table('system_modulos_menus')->insert([
            'nombre' => 'Accesos',
            'key' => 'system-accesos',
            'route' => '/system-accesos',
            'mdi_icon' => 'mdi-key-chain-variant',
            'created_at' => date('Y-m-d h:i:s'),
            'modulo_id' => 1
        ]);
        // MENUS
    }
}
