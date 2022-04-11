<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_users')->insert(
            [
                'id' => 1,
                'status' => 'Activo'
            ],
            [
                'id' => 2,
                'status' => 'Baja'
            ]
        );
    }
}
