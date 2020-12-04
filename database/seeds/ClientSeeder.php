<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('clients')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'phoneNumber' => '1212121212',
            ),
        ));
    }
}
