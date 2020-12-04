<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class SerieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('series')->insert(array (
            0 => 
            array (
                'name' => 'harry potter',
            ),
            1 => 
            array (
                'name' => 'lord of the rings',
            ),
            2 => 
            array (
                'name' => 'game of thrones',
            ),
        ));
    }
}
