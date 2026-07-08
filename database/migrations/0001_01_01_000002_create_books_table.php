<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id('book_id');
            $table->string('isbn', 20)->unique();
            $table->string('title', 255);
            $table->string('author', 150);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('publisher', 150)->nullable();
            $table->smallInteger('published_year')->nullable();
            $table->string('edition', 50)->nullable();
            $table->string('shelf_location', 50)->nullable();
            $table->unsignedInteger('total_copies')->default(1);
            $table->unsignedInteger('available_copies')->default(1);
            $table->string('status', 20)->default('available');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('set null')->onUpdate('cascade');
            $table->index('title', 'idx_books_title');
            $table->index('author', 'idx_books_author');
            $table->index('category_id', 'idx_books_category');
        });

        // PostgreSQL check constraints for stock
        DB::statement('ALTER TABLE books ADD CONSTRAINT chk_books_stock CHECK (available_copies >= 0 AND available_copies <= total_copies)');
        DB::statement("ALTER TABLE books ADD CONSTRAINT chk_books_status CHECK (status IN ('available','unavailable','archived'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
