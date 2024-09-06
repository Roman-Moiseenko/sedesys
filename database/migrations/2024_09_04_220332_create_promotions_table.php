<?php

use App\Modules\Base\Entity\DisplayedModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            DisplayedModel::columns($table);
            $table->string('description')->default('');
            $table->string('condition_url')->default('');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('finish_at')->nullable();
            $table->integer('discount')->default(0);
            $table->boolean('current')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotions');
    }
};
