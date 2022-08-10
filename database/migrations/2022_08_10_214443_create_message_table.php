<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message', function (Blueprint $table) { 
            $table->bigInteger('messageNo', 20);
            $table->text('messageContent');
            $table->dateTime('createTime', 0)->useCurrent();
            $table->dateTime('updateTime', 0)->useCurrent()->useCurrentOnUpdate();
            $table->string('imgUrl', 50)->nullable();;
            $table->string('articleNo', 50);
            $table->string('userNo', 45);
            $table->index(['articleNo', 'messageNo', 'userNo']);
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message');
    }
};
