<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class BookClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('book_client')->insert(array (
            0 => 
            array (
                'book_id' => '2',
                'client_id' => '1',
            ),
        ));
    }
}
