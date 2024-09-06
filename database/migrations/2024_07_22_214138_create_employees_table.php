<?php

use App\Modules\Base\Entity\DisplayedModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->unique();
            $table->string('password');
            $table->float('rating')->default(0);
            $table->integer('telegram_user_id')->nullable();
            $table->integer('experience_year')->nullable();
            $table->json('fullname');
            $table->json('address');
            DisplayedModel::columns($table);
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
