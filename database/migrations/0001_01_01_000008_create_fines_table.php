<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fines', function (Blueprint $table) {
            $table->id('fine_id');
            $table->unsignedBigInteger('borrowing_id');
            $table->unsignedBigInteger('member_id');
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('reason', 255)->nullable();
            $table->string('status', 20)->default('unpaid');
            $table->date('issued_date')->useCurrent();
            $table->date('paid_date')->nullable();

            $table->foreign('borrowing_id')->references('borrowing_id')->on('borrowings')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('member_id')->references('member_id')->on('members')->onDelete('cascade')->onUpdate('cascade');
            $table->index('borrowing_id', 'fk_fines_borrow');
            $table->index('member_id', 'fk_fines_member');
            $table->index('status', 'idx_fines_status');
        });

        DB::statement("ALTER TABLE fines ADD CONSTRAINT chk_fines_status CHECK (status IN ('unpaid','paid','waived'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('fines');
    }
};
