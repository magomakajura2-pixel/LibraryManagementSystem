<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id('member_id');
            $table->string('membership_no', 30)->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('first_name', 80);
            $table->string('last_name', 80);
            $table->string('email', 150)->nullable()->unique();
            $table->string('phone', 30)->nullable();
            $table->string('address', 255)->nullable();
            $table->date('join_date')->useCurrent();
            $table->string('status', 20)->default('active');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->index(['last_name', 'first_name'], 'idx_members_name');
        });

        DB::statement("ALTER TABLE members ADD CONSTRAINT chk_members_status CHECK (status IN ('active','suspended','expired'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
