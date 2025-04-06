<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ab_user', function (Blueprint $table) {
            $table->increments('id');

            $table->string('ab_name', 80)->notNull();
            $table->string('ab_password', 200)->notNull();
            $table->string('ab_mail', 200)->notNull()->unique();

        });
    }

    public function down()
    {
        Schema::dropIfExists('ab_user');
    }
};
