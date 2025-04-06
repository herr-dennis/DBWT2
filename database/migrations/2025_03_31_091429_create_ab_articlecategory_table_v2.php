<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ab_articlecategory', function (Blueprint $table) {
            $table->increments('id');

            $table->string('ab_name', 100)->notNull();
            $table->string('ab_description', 1000)->nullable();

            $table->integer('ab_parent')->unsigned()->nullable();

            $table->foreign('ab_parent')
                ->references('id')
                ->on('ab_articlecategory')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ab_articlecategory');
    }
};
