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
        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->default(\App\Modules\User\Entity\User::STATUS_WAIT);
            $table->string('phone')->default('');
            $table->json('fullname');
            $table->json('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('phone');
            $table->dropColumn('fullname');
            $table->dropColumn('address');
        });
    }
};
