<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

return new class extends Migration
{

    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->timestamp('activated_at')->nullable();
            $table->boolean('active')->default(false);
            $table->string('awesome')->nullable();
            $table->json('meta');
            $table->string('template')->default('text');
            $table->longText('text');
            NestedSet::columns($table);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pages');
    }
};
