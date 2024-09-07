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
        Schema::table('specializations', function (Blueprint $table) {
            $table->string('template')->nullable();
            $table->longText('text')->nullable();
        });
        Schema::table('classifications', function (Blueprint $table) {
            $table->string('template')->nullable();
            $table->longText('text')->nullable();
        });
        Schema::table('employees', function (Blueprint $table) {
            $table->string('template')->nullable();
            $table->longText('text')->nullable();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->string('template')->nullable()->change();
            $table->longText('text')->nullable()->change();
        });
        Schema::table('services', function (Blueprint $table) {
            $table->string('template')->nullable()->change();
            $table->longText('text')->nullable()->change();
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
