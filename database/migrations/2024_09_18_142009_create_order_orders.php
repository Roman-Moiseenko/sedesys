<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('staff_id')->nullable()->constrained('admins')->onDelete('set null');
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->onDelete('set null');
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->integer('manual_discount')->nullable();
            $table->integer('base');
            $table->string('number')->nullable();
            $table->string('comment')->default('');
            $table->timestamps();
        });

        if (Schema::hasTable('calendars')) {
            Schema::table('calendars', function (Blueprint $table) {
                $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            });
        }

        if (Schema::hasTable('feedback')) {
            Schema::table('feedback', function (Blueprint $table) {
                $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('calendars')) {
            Schema::table('calendars', function (Blueprint $table) {
                $table->dropForeign(['order_id']);
            });
            Schema::table('calendars', function (Blueprint $table) {
                $table->dropColumn('order_id');
            });
        }

        if (Schema::hasTable('feedback')) {
            Schema::table('feedback', function (Blueprint $table) {
                $table->dropForeign(['order_id']);
            });
            Schema::table('feedback', function (Blueprint $table) {
                $table->dropColumn('order_id');
            });
        }

        Schema::dropIfExists('orders');
    }
};
