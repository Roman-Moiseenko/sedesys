<?php

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
            $table->string('name');
            $table->string('slug');
            $table->string('awesome')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamp('activated_at')->nullable();
            $table->json('meta');
            $table->timestamps();
            NestedSet::columns($table);
        });
    }

    public function down()
    {
        Schema::dropIfExists('classifications');
    }
};
