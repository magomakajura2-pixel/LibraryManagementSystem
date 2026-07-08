<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id('log_id');
            $table->string('actor', 150);
            $table->string('action', 20);
            $table->string('table_name', 64);
            $table->string('record_id', 64)->nullable();
            $table->string('details', 500)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['table_name', 'created_at'], 'idx_audit_table');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
