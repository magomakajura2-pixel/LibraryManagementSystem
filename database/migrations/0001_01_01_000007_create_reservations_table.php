<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('reservation_id');
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('member_id');
            $table->date('reserved_date')->useCurrent();
            $table->date('expiry_date')->nullable();
            $table->string('status', 20)->default('pending');

            $table->foreign('book_id')->references('book_id')->on('books')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('member_id')->references('member_id')->on('members')->onDelete('cascade')->onUpdate('cascade');
            $table->index('book_id', 'fk_res_book');
            $table->index('member_id', 'fk_res_member');
        });

        DB::statement("ALTER TABLE reservations ADD CONSTRAINT chk_reservations_status CHECK (status IN ('pending','fulfilled','cancelled','expired'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
