<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('librarians', function (Blueprint $table) {
            $table->id('librarian_id');
            $table->unsignedBigInteger('user_id');
            $table->string('employee_no', 30)->unique();
            $table->string('first_name', 80);
            $table->string('last_name', 80);
            $table->string('email', 150)->nullable();
            $table->string('phone', 30)->nullable();
            $table->date('hire_date')->useCurrent();
            $table->string('privilege_level', 20)->default('assistant');
            $table->string('status', 20)->default('active');

            $table->foreign('user_id')->references('user_id')->on('users')->onUpdate('cascade');
            $table->index('user_id', 'fk_librarians_user');
        });

        DB::statement("ALTER TABLE librarians ADD CONSTRAINT chk_librarians_privilege CHECK (privilege_level IN ('librarian','assistant'))");
        DB::statement("ALTER TABLE librarians ADD CONSTRAINT chk_librarians_status CHECK (status IN ('active','inactive'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('librarians');
    }
};
