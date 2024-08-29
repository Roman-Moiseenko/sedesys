<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->unique();
            $table->string('password');
            $table->boolean('active')->default(true);
            $table->timestamp('activated_at')->nullable();
            $table->float('rating')->default(0);
            $table->timestamps();
            $table->integer('telegram_user_id')->nullable();
            $table->integer('experience_year')->nullable();
            $table->json('fullname');
            $table->json('address');
            $table->string('name')->nullable();
            $table->string('slug');
            $table->string('awesome')->nullable();
            $table->json('meta');
            $table->json('breadcrumb');
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
