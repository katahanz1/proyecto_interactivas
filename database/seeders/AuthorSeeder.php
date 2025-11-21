<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        Author::create(['name' => 'J.K. Rowling', 'bio' => 'British author, best known for the Harry Potter series.']);
        Author::create(['name' => 'George R.R. Martin', 'bio' => 'American novelist and short story writer.']);
        Author::create(['name' => 'Isaac Asimov', 'bio' => 'American writer and professor of biochemistry.']);
        Author::create(['name' => 'Walter Isaacson', 'bio' => 'American writer and journalist.']);
    }
}
