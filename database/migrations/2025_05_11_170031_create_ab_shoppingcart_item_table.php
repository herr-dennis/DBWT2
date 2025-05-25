<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ab_shoppingcart_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ab_shoppingcart_id');
            $table->unsignedBigInteger('ab_article_id');
            $table->timestamp('ab_createdate')->useCurrent();

            $table->foreign('ab_shoppingcart_id')
                ->references('id')->on('ab_shoppingcart')
                ->onDelete('cascade');

            $table->foreign('ab_article_id')
                ->references('id')->on('ab_article')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ab_shoppingcart_item');
    }
};
