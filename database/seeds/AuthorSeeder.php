<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('authors')->insert(array (
            0 => 
            array (
                'name' => 'shakes spear',
                'imageName' => 'shakes spear.jpg',
            ),
            1 => 
            array (
                'name' => 'GEORGE R.R. MARTIN',
                'imageName' => 'GEORGE R.R. MARTIN.jpg',
            ),
            2 => 
            array (
                'name' => ' elisabeth moss',
                'imageName' => 'elisabeth moss.jpg',
            ),
            3 => 
            array (
                'name' => 'ERNEST HEMINGWAY',
                'imageName' => '',
            ),
            4 => 
            array (
                'name' => 'GEORGE R.R. MARTIN',
                'imageName' => 'GEORGE R.R. MARTIN.jpg',
            ),
            5 => 
            array (
                'name' => ' J.K. ROWLING',
                'imageName' => '',
            ),
        ));
    }
}
