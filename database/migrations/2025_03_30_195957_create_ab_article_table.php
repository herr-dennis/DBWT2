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
        Schema::create('ab_article', function (Blueprint $table) {
            $table->id();
            $table->string('ab_name', 80)->notNull();
            $table->integer('ab_price')->notNull();
            $table->string('ab_description', 1000)->notNull();
            $table->unsignedBigInteger('ab_creator_id'); // Fremdschlüssel zu ab_user
            $table->timestamp('ab_createdate')->notNull();
            $table->timestamps();

            // Fremdschlüssel setzen
            $table->foreign('ab_creator_id')->references('id')->on('ab_user')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ab_article');
    }
};
