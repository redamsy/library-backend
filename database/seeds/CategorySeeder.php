<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('categories')->insert(array (
            0 => 
            array (
                'name' => 'sci-fi',
            ),
            1 => 
            array (
                'name' => 'drama',
            ),
            2 => 
            array (
                'name' => 'action',
            ),
            3 => 
            array (
                'name' => 'adventure',
            ),
            4 => 
            array (
                'name' => 'crime',
            ),
        ));
    }
}
