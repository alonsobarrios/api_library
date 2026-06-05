<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = Author::pluck('id');
        Book::factory(20)->create()->each(function ($book) use ($authors) {
            $selectedAuthors = $authors->random(rand(1, 3));
            $pivotData = [];

            foreach ($selectedAuthors as $index => $authorId) {
                $pivotData[$authorId] = [
                    'author_order' => $index + 1
                ];
            }

            $book->authors()->attach($pivotData);
        });
    }
}
