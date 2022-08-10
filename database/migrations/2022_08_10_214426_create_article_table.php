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
        Schema::create('article', function (Blueprint $table) {
            $table->string('articleNo', 50);
            $table->string('articleTitle', 50);
            $table->text('articleContent');
            $table->dateTime('createTime', 0)->useCurrent();
            $table->dateTime('updateTime', 0)->useCurrent()->useCurrentOnUpdate();
            $table->string('imgUrl', 50)->nullable();;
            $table->string('userNo', 45);
            $table->primary('articleNo');
            $table->index(['articleNo', 'userNo']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article');
    }
};
