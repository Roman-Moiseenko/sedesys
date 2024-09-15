<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('rules_services', function (Blueprint $table) {
            $table->foreignId('rule_id')->constrained('rules')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rules_services');
    }
};