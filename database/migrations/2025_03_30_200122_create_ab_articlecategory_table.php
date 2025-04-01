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
        Schema::create('ab_articlecategory', function (Blueprint $table) {
            $table->id();
            $table->string('ab_name', 100)->unique();
            $table->string('ab_description', 1000)->nullable();
            $table->timestamps();
            /*
             * ab_parent zeigt auf die ID von ab_ariclecategory
             * Bsp: Bücher hat ab_parent null / Wurzelknoten
             * IT-Bücher verweist dann auf Bücher, also der ID der Büchen
             * Buch Webtechnologie verweist dann auf die ID von IT Büchern.
             */
            $table->foreignId('ab_parent')->nullable()->constrained('ab_articlecategory')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ab_articlecategory');
    }
};
