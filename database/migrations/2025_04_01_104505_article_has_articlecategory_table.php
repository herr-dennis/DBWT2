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
        Schema::create('ab_article_has_articlecategory', function (Blueprint $table) {
            $table->id(); // Primärschlüssel (uint8 → bigIncrements)
            $table->foreignId('ab_articlecategory_id')->constrained('ab_articlecategory')->onDelete('cascade');
            $table->foreignId('ab_article_id')->constrained('ab_article')->onDelete('cascade');
            /*
             * Eine Nebenbedingung, verhindert doppelte Einträge.
             */
            $table->unique(['ab_articlecategory_id', 'ab_article_id']); // UNIQUE Constraint
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ab_article_has_articlecategory');
    }
};
