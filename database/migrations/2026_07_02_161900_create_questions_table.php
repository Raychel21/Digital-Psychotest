<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->text('text');
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('required')->default(true);
            $table->json('settings')->nullable();
            $table->timestamps();

            $table->index(['assessment_id', 'sort']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
