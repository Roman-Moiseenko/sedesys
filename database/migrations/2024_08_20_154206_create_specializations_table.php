<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('specializations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->json('meta');
            $table->json('breadcrumb');
            $table->boolean('active')->default(false);
            $table->string('awesome')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->integer('sort')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('specializations');
    }
};
