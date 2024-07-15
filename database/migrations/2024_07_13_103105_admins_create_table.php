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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            //$table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('role');
            $table->string('post', 33)->default('');
            $table->boolean('active')->default(true);
            $table->rememberToken();
            $table->timestamps(); // $timestamps = true - по умолчанию,
            $table->integer('telegram_user_id')->nullable();
            $table->json('fullname');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('admins');
    }
};
