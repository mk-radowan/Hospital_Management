<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('specialization');
            $table->string('qualification');
            $table->integer('experience_years')->default(0);
            $table->decimal('consultation_fee', 8, 2)->default(0);
            $table->string('license_number')->unique();
            $table->json('available_days')->nullable(); // ['monday', 'tuesday', etc.]
            $table->time('available_time_start')->default('09:00');
            $table->time('available_time_end')->default('17:00');
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};