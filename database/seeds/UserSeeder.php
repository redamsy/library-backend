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
        //
        DB::table('users')->insert(array (
            0 => 
            array (
                'name' => 'test1',
                'email' => 'test1@gmail.com',
                'password' => '12345678',
            ),
            1 => 
            array (
                'name' => 'test2',
                'email' => 'test2@gmail.com',
                'password' => '12345678',
            ),
        ));
    }
}
