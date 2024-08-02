<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->timestamp('published_at')->nullable();
            $table->boolean('published')->default(false);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('title')->default('');
            $table->text('description');
            $table->string('template')->default('text');
            $table->longText('text');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pages');
    }
};
