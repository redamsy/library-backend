<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class BookAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('book_author')->insert(array (
            0 => 
            array (
                'book_id' => '1',
                'author_id' => '2',
            ),
            1 => 
            array (
                'book_id' => '2',
                'author_id' => '1',
            ),
            2 => 
            array (
                'book_id' => '3',
                'author_id' => '2',
            ),
            3 => 
            array (
                'book_id' => '3',
                'author_id' => '3',
            ),
        ));
    }
}
