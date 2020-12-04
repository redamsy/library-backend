<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('books')->insert(array (
            0 => 
            array (
                'publisher_id' => 1,
                'serie_id' => 1,
                'language_id' => 2,
                'title' => 'game of thrones season 1',
                'description' => 'winter is coming',
                'publishDate' => '2020-08-18 13:57:10',
                'price' => 10,
                'chapters' => 8,
                'pages' => 700,
                'isProhibited' => 0,
                'imageName' => 'got2.jpg',
                'pdfName' => 'critical_thinking_consider_the_verdict__6th_edition.pdf',
            ),
            1 => 
            array (
                'publisher_id' => 1,
                'serie_id' => 2,
                'language_id' => 2,
                'title' => 'harry potter and the half blood price',
                'description' => "Harry Potter and the Half-Blood Prince is the sixth novel in J. K. Rowling's Harry Potter series. Set during Harry Potter's sixth year at Hogwarts, Lord Voldemort is definitely back, and with a vengeance.",
                'publishDate' => '2020-08-18 13:57:10',
                'price' => 0,
                'chapters' => 10,
                'pages' => 500,
                'isProhibited' => 0,
                'imageName' => 'harry potter.jpg',
                'pdfName' => 'critical_thinking_consider_the_verdict__6th_edition.pdf',
            ),
            2 => 
            array (
                'publisher_id' => 3,
                'serie_id' => 2,
                'language_id' => 2,
                'title' => 'harray potter and the prisoner of azkaban',
                'description' => "The book follows Harry Potter, a young wizard, in his third year at Hogwarts School of Witchcraft and Wizardry. Along with friends Ronald Weasley and Hermione Granger, Harry investigates Sirius Black, an escaped prisoner from Azkaban, the wizard prison, believed to be one of Lord Voldemort's old allies.",
                'publishDate' => '2020-08-18 13:57:10',
                'price' => 0,
                'chapters' => 5,
                'pages' => 450,
                'isProhibited' => 0,
                'imageName' => 'harry potter 2.jpg',
                'pdfName' => 'critical_thinking_consider_the_verdict__6th_edition.pdf',
            ),
        ));
    }
}
