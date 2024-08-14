<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('system_mails', function (Blueprint $table) {
            $table->id();
            $table->string('mailable');
            $table->integer('user_id');
            $table->mediumText('content');
            $table->json('attachments');
            $table->integer('count')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('system_mails');
    }
};
