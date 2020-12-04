<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class BookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('book_category')->insert(array (
            0 => 
            array (
                'book_id' => '2',
                'category_id' => '1',
            ),
        ));
    }
}
