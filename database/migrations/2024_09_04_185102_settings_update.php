<?php

use App\Modules\Setting\Entity\Schedule;
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
            'name' => 'Настройки расписания',
            'slug' => 'schedule',
            'description' => 'Режим работы и планировка расписания работы персонала. Праздники и выходные, режимы работы',
            'class' => Schedule::class,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Setting::where('slug', 'schedule')->first()->delete();
    }
};
