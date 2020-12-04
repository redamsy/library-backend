<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('languages')->insert(array (
            0 => 
            array (
                'code' => 'en',
                'name' => 'english',
            ),
            1 => 
            array (
                'code' => 'fr',
                'name' => 'french',
            ),
            2 => 
            array (
                'code' => 'chi',
                'name' => 'chinese',
            ),
        ));
    }
}
