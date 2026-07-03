<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->text('label');
            $table->unsignedInteger('sort')->default(0);
            $table->json('scores')->nullable();
            $table->timestamps();

            $table->index(['question_id', 'sort']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};
