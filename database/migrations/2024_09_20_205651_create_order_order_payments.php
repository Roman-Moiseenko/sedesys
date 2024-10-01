<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('staff_id')->nullable()->constrained('admins')->onDelete('set null');
            $table->integer('amount');
            $table->integer('method');
            $table->string('document')->default('');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_payments');
    }
};