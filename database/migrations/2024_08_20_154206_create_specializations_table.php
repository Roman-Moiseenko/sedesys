<?php

use App\Modules\Base\Entity\DisplayedModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('specializations', function (Blueprint $table) {
            $table->id();
            DisplayedModel::columns($table);
            $table->integer('sort')->default(0);

        });
    }

    public function down()
    {
        Schema::dropIfExists('specializations');
    }
};
