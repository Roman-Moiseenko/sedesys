<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('services_extra', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->string('description')->default('');
            $table->integer('price')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('sort')->default(0);
            $table->string('awesome')->nullable();
            $table->boolean('active')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('services_extra');
    }
};
