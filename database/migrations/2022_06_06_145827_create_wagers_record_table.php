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
        Schema::create('wagersRecord', function (Blueprint $table) {
            $table->string('WagersID', 45);
            $table->dateTime('WagersDate', 0);
            $table->string('SerialID', 10)->nullable();
            $table->string('GameType', 20);
            $table->string('Result', 1);
            $table->decimal('BetAmount', 14, 4);
            $table->decimal('Commissionable', 18, 8);
            $table->decimal('Payoff', 14, 4);
            $table->string('Currency', 5);
            $table->decimal('ExchangeRate', 16, 6);
            $table->dateTime('ModifiedDate', 0);
            $table->string('Origin', 3);
            $table->integer('Star')->nullable();
            $table->string('userNo', 45);

            $table->primary('WagersID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wagersRecord');
    }
};
