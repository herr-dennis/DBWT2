<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ab_article', function (Blueprint $table) {
            $table->increments('id');

            $table->string('ab_name', 80)->notNull();
            $table->integer('ab_price')->notNull();
            $table->string('ab_description', 1000)->notNull();

            $table->integer('ab_creator_id')->unsigned();
            $table->timestamp('ab_createdate')->notNull();

            $table->foreign('ab_creator_id')
                ->references('id')
                ->on('ab_user')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ab_article');
    }
};
