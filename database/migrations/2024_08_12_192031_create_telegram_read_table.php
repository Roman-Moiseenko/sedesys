<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('telegram_reads', function (Blueprint $table) {
            $table->id();
            $table->integer('message_id');
            $table->integer('telegram_user_id');
            $table->string('message');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('telegram_reads');
    }
};
