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
            $table->json('breadcrumb');
        });
        Schema::table('services', function (Blueprint $table) {
            $table->json('breadcrumb');
        });
        Schema::table('classifications', function (Blueprint $table) {
            $table->json('breadcrumb');
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->json('breadcrumb');
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
