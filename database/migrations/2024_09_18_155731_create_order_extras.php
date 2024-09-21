<?php

use App\Modules\Order\Entity\OrderItem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('order_extras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('extra_id')->constrained('services_extra')->onDelete('cascade');
            OrderItem::columns($table);
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_extras');
    }
};
