<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('services_consumables', function (Blueprint $table) {
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('consumable_id')->constrained('consumables')->onDelete('cascade');
            $table->integer('count')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('services_consumables');
    }
};
