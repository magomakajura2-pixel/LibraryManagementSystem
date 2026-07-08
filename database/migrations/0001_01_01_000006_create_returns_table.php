<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->id('return_id');
            $table->unsignedBigInteger('borrowing_id')->unique();
            $table->date('return_date')->useCurrent();
            $table->string('book_condition', 20)->default('good');
            $table->unsignedBigInteger('received_by')->nullable();
            $table->string('remarks', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('borrowing_id')->references('borrowing_id')->on('borrowings')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('received_by')->references('librarian_id')->on('librarians')->onDelete('set null')->onUpdate('cascade');
            $table->index('received_by', 'fk_returns_by');
            $table->index('return_date', 'idx_returns_date');
        });

        DB::statement("ALTER TABLE returns ADD CONSTRAINT chk_returns_condition CHECK (book_condition IN ('good','damaged','lost'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
