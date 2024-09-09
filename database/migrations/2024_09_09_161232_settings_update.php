<?php

use App\Modules\Setting\Entity\Discount;
use App\Modules\Setting\Entity\Setting;
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
        Setting::create([
            'name' => 'Настройки скидок',
            'slug' => 'discount',
            'description' => 'Настройки размера скидок, длины и сложности кодов купонов, минимальные и максимальные ограничения',
            'class' => Discount::class,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Setting::where('slug', 'discount')->first()->delete();
    }
};
