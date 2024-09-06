<?php

use App\Modules\Base\Entity\DisplayedModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

return new class extends Migration
{

    public function up()
    {
        Schema::create('classifications', function (Blueprint $table) {
            $table->id();
            DisplayedModel::columns($table);
            NestedSet::columns($table);
        });
    }

    public function down()
    {
        Schema::dropIfExists('classifications');
    }
};
