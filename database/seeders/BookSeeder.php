<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            ['isbn' => '978-0131103627', 'title' => 'The C Programming Language', 'author' => 'Kernighan & Ritchie', 'category_id' => 1, 'publisher' => 'Prentice Hall', 'published_year' => 1988, 'shelf_location' => 'CS-A1', 'total_copies' => 3, 'available_copies' => 3],
            ['isbn' => '978-0262033848', 'title' => 'Introduction to Algorithms', 'author' => 'Cormen et al.', 'category_id' => 1, 'publisher' => 'MIT Press', 'published_year' => 2009, 'shelf_location' => 'CS-A2', 'total_copies' => 2, 'available_copies' => 2],
            ['isbn' => '978-0596009205', 'title' => 'Head First SQL', 'author' => 'Lynn Beighley', 'category_id' => 1, 'publisher' => "O'Reilly", 'published_year' => 2007, 'shelf_location' => 'CS-B1', 'total_copies' => 4, 'available_copies' => 4],
            ['isbn' => '978-0201558029', 'title' => 'Concrete Mathematics', 'author' => 'Graham, Knuth, Patashnik', 'category_id' => 2, 'publisher' => 'Addison-Wesley', 'published_year' => 1994, 'shelf_location' => 'MA-C1', 'total_copies' => 2, 'available_copies' => 2],
            ['isbn' => '978-0141439518', 'title' => 'Pride and Prejudice', 'author' => 'Jane Austen', 'category_id' => 3, 'publisher' => 'Penguin', 'published_year' => 1813, 'shelf_location' => 'FI-D1', 'total_copies' => 5, 'available_copies' => 5],
            ['isbn' => '978-0316769488', 'title' => 'The Catcher in the Rye', 'author' => 'J. D. Salinger', 'category_id' => 3, 'publisher' => 'Little, Brown', 'published_year' => 1951, 'shelf_location' => 'FI-D2', 'total_copies' => 1, 'available_copies' => 1],
            ['isbn' => '978-0060935467', 'title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee', 'category_id' => 3, 'publisher' => 'Harper Perennial', 'published_year' => 1960, 'shelf_location' => 'FI-D3', 'total_copies' => 3, 'available_copies' => 3],
            ['isbn' => '978-1400079278', 'title' => 'A History of the World', 'author' => 'Andrew Marr', 'category_id' => 4, 'publisher' => 'Pan Books', 'published_year' => 2012, 'shelf_location' => 'HI-E1', 'total_copies' => 2, 'available_copies' => 2],
        ];

        foreach ($books as $book) {
            DB::table('books')->insertOrIgnore($book);
        }
    }
}
