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
        Schema::create('disc_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disc_question_id')->constrained('disc_questions')->onDelete('cascade');
            $table->string('statement');
            $table->char('most_value', 1);
            $table->char('least_value', 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disc_items');
    }
};
