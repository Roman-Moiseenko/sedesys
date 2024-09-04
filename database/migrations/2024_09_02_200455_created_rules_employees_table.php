<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('rules_employees', function (Blueprint $table) {
            $table->foreignId('rule_id')->constrained('rules')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rules_employees');
    }
};
