<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('imageable_id');
            $table->string('imageable_type');
            $table->string('file');
            $table->string('alt')->default('');
            $table->integer('sort')->default(0);
            $table->string('type')->default('');
            $table->string('title')->default('');
            $table->string('description')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }

};
