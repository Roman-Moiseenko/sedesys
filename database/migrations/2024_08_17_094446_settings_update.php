<?php

use App\Modules\Setting\Entity\Mail;
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
            'name' => 'Настройки почты',
            'slug' => 'mail',
            'description' => 'Настройка входящей почты - почтовые ящики (+пароли), с которых необходимо собирать почту, Настройки исходящей и системной почты',
            'class' => Mail::class,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Setting::where('slug', 'notification')->first()->delete();
    }
};
