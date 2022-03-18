<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'usuario prueba',
            'email' => 'correo_prueba_@hotmail.com',
            'password' => Hash::make('password'),
            'id_profile' => 1, // administrador
            'id_status' => 1 // activo
        ]);
    }
}
