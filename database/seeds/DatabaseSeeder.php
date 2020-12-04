<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(PublisherSeeder::class);
        $this->call(SerieSeeder::class);
        $this->call(AuthorSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(BookSeeder::class);
        $this->call(BookClientSeeder::class);
        $this->call(BookCategorySeeder::class);
        $this->call(BookAuthorSeeder::class);
    }
}
