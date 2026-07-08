<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id('borrowing_id');
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('librarian_id')->nullable();
            $table->date('borrow_date')->useCurrent();
            $table->date('due_date');
            $table->string('status', 20)->default('borrowed');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('book_id')->references('book_id')->on('books')->onUpdate('cascade');
            $table->foreign('member_id')->references('member_id')->on('members')->onUpdate('cascade');
            $table->foreign('librarian_id')->references('librarian_id')->on('librarians')->onDelete('set null')->onUpdate('cascade');
            $table->index('librarian_id', 'fk_borrow_librarian');
            $table->index('status', 'idx_borrow_status');
            $table->index('due_date', 'idx_borrow_due');
            $table->index('book_id', 'idx_borrow_book');
            $table->index('member_id', 'idx_borrow_member');
        });

        DB::statement("ALTER TABLE borrowings ADD CONSTRAINT chk_borrow_status CHECK (status IN ('borrowed','returned','overdue','lost'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
