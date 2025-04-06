<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ab_article_has_articlecategory', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('ab_articlecategory_id')->unsigned();
            $table->integer('ab_article_id')->unsigned();

            $table->unique(['ab_articlecategory_id', 'ab_article_id']);

            $table->foreign('ab_articlecategory_id')
                ->references('id')
                ->on('ab_articlecategory')
                ->onDelete('cascade');

            $table->foreign('ab_article_id')
                ->references('id')
                ->on('ab_article')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ab_article_has_articlecategory');
    }
};
