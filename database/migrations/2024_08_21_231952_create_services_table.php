<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->boolean('active')->default(false);
            $table->string('awesome')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->longText('text');
            $table->integer('price')->nullable();
            $table->integer('duration')->nullable();
            $table->string('template')->nullable();
            $table->foreignId('classification_id')->nullable()->constrained('classifications')->onDelete('set null');
            $table->timestamps();
            $table->json('meta');
            $table->json('data');
        });
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
};
