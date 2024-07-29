<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->string('template')->default('text');
            $table->json('data');
            $table->json('options');
            $table->string('model')->default('');
        });
    }

    public function down()
    {
        Schema::dropIfExists('widgets');
    }
};
