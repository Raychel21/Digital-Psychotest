<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interpretations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('dimension_id')->constrained()->cascadeOnDelete();
            $table->string('scale')->default('sum');
            $table->integer('min_value');
            $table->integer('max_value');
            $table->string('title');
            $table->text('body');
            $table->timestamps();

            $table->index(['dimension_id', 'scale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interpretations');
    }
};
