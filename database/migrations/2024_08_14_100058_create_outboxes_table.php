<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('outboxes', function (Blueprint $table) {
            $table->id();
            $table->integer('staff_id');
            $table->json('emails');
            $table->string('subject');
            $table->mediumText('message');
            $table->json('attachments');
            $table->boolean('sent')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('outboxes');
    }
};
