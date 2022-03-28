<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->insert([
            'id' => '1',
            'profile' => 'Administrador',
        ]);
      
         DB::table('profiles')->insert([
            'id' => '2',
            'profile' => 'Prestatario',
        ]);
    }
}
