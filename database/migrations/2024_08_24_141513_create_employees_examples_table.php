<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('employees_examples', function (Blueprint $table) {
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('example_id')->constrained('examples')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees_examples');
    }
};
