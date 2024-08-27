<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('specializations', function (Blueprint $table) {
            $table->string('awesome')->nullable();
            $table->timestamp('activated_at')->nullable();
        });
        Schema::table('classifications', function (Blueprint $table) {
            $table->string('awesome')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamp('activated_at')->nullable();
        });
        Schema::table('services', function (Blueprint $table) {
            $table->string('awesome')->nullable();
            $table->timestamp('activated_at')->nullable();
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->string('awesome')->nullable();
            $table->renameColumn('published_at', 'activated_at');
            $table->renameColumn('published', 'active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*Schema::table('specializations', function (Blueprint $table) {
            $table->dropColumn('awesome');
            $table->dropColumn('activated_at');
        });
        Schema::table('classifications', function (Blueprint $table) {
            $table->dropColumn('awesome');
            $table->dropColumn('activated_at');
            $table->dropColumn('active');
        });
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('awesome');
            $table->dropColumn('activated_at');
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('awesome')->nullable();
            $table->renameColumn('activated_at', 'published_at');
            $table->renameColumn('active', 'published');
        });*/
    }
};
