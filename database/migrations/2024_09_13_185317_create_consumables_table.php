<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('consumables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->default('');
            $table->integer('price')->default(0);
            $table->boolean('active')->default(false);
            $table->boolean('show')->default(false);
            $table->integer('count')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consumables');
    }
};
