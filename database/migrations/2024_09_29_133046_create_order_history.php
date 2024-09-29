<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('order_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->nullable()->constrained('admins')->onDelete('set null');
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('action');
            $table->string('object')->default('');
            $table->string('value')->default('');
            $table->string('url')->default('');
            $table->timestamp('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_history');
    }
};
