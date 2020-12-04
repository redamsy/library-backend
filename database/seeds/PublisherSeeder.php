<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('publishers')->insert(array (
            0 => 
            array (
                'name' => 'Penguin Random House.',
            ),
            1 => 
            array (
                'name' => 'Hachette Livre',
            ),
            2 => 
            array (
                'name' => 'HarperCollins',
            ),
        ));
    }
}
