<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_storages', function (Blueprint $table) {
            $table->id();

            $table->string('phone')->default('-');
            $table->string('sms')->default('-');
            $table->string('name')->default('-');
//            $table->foreignId('city_id')->nullable()->constrained();


            $table->string('telegram_id');
            $table->string('lang')->default('ru');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_storages');
    }
}
