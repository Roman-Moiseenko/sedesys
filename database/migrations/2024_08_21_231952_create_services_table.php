<?php

use App\Modules\Base\Entity\DisplayedModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            DisplayedModel::columns($table);
            $table->longText('text');
            $table->integer('price')->nullable();
            $table->integer('duration')->nullable();
            $table->string('template')->nullable();
            $table->foreignId('classification_id')->nullable()->constrained('classifications')->onDelete('set null');
            $table->json('data');
        });
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
};
