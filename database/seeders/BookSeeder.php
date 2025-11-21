<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $author = \App\Models\Author::first();
        $category = \App\Models\Category::first();

        if ($author && $category) {
            \App\Models\Book::firstOrCreate([
                'isbn' => '978-0439708180',
            ], [
                'title' => 'Harry Potter and the Sorcerer\'s Stone',
                'author_id' => $author->id,
                'category_id' => $category->id,
                'published_year' => 1997,
                'stock' => 10,
                'cover_image' => null,
            ]);

            \App\Models\Book::firstOrCreate([
                'isbn' => '978-0451524935',
            ], [
                'title' => '1984',
                'author_id' => $author->id,
                'category_id' => $category->id,
                'published_year' => 1949,
                'stock' => 5,
                'cover_image' => null,
            ]);
        }
    }
}
