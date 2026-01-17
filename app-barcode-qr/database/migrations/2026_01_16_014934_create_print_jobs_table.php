<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('print_jobs', function (Blueprint $table) {
            $table->id();

            $table->string('job_token')->unique();
            $table->string('file_name');
            $table->string('file_path');

            $table->unsignedInteger('total_pages');
            $table->unsignedInteger('copies')->default(1);

            $table->enum('print_mode', ['bw', 'color'])->default('bw');

            $table->enum('status', ['queued', 'printing', 'done', 'failed'])
                  ->default('queued');

            $table->string('source')->default('qr');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('print_jobs');
    }
};
