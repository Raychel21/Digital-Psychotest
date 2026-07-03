<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('norms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dimension_id')->constrained()->cascadeOnDelete();
            $table->string('scale');
            $table->integer('raw_min');
            $table->integer('raw_max');
            $table->integer('value');
            $table->timestamps();

            $table->index(['dimension_id', 'scale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('norms');
    }
};
