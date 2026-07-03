<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->json('logic')->nullable();
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->json('logic')->nullable();
            $table->string('image_path')->nullable();
        });

        Schema::table('options', function (Blueprint $table) {
            $table->string('image_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropColumn('logic');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['logic', 'image_path']);
        });

        Schema::table('options', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }
};
