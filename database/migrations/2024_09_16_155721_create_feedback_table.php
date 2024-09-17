<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('feedback_templates')->onDelete('cascade');
            $table->string('email')->default('');
            $table->string('phone')->default('');
            $table->string('user')->default('');
            $table->string('message')->default('');
            $table->json('data');
            $table->foreignId('staff_id')->nullable()->constrained('admins')->onDelete('set null');
            $table->integer('status');
            $table->boolean('archive')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedback');
    }
};
