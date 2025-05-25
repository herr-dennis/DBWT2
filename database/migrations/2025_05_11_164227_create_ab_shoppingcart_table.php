<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ab_shoppingcart', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ab_creator_id');
            $table->timestamp('ab_createdate')->useCurrent();

            $table->foreign('ab_creator_id')
                ->references('id')->on('ab_user')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ab_shoppingcart');
    }
};
