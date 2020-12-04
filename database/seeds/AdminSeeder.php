<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('admins')->insert(array (
            0 => 
            array (
                'id' => 2,
                'user_id' => 2,
            ),
        ));
    }
}
