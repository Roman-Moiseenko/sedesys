<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('inboxes', function (Blueprint $table) {
            $table->id();
            $table->string('box');
            $table->string('email');
            $table->string('subject');
            $table->mediumText('message');
            $table->json('attachments');
            $table->boolean('read')->default(false);
            $table->timestamps();
            $table->timestamp('read_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inboxes');
    }
};
