<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dimensions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->cascadeOnDelete();
            $table->string('code', 16);
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();

            $table->unique(['assessment_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dimensions');
    }
};
