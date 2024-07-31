<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->boolean('active')->default(false);
            $table->string('title')->default('');
            $table->string('icon')->default('');
            $table->string('url')->default('');
            $table->string('color')->default('');
            $table->integer('sort')->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};
