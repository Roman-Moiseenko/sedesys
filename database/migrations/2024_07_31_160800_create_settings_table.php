<?php

use App\Modules\Setting\Entity\Office;
use App\Modules\Setting\Entity\Organization;
use App\Modules\Setting\Entity\Setting;
use App\Modules\Setting\Entity\Web;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('class');
            $table->string('description');
            $table->json('data');
            $table->timestamps();
        });

        Setting::create([
            'name' => 'Настройки организации',
            'slug' => 'organization',
            'description' => 'Юридические данные о компании, отображаемые на вкладе о нас и/или контакты',
            'class' => Organization::class,
        ]);
        Setting::create([
            'name' => 'Настройки офиса',
            'slug' => 'office',
            'description' => 'Данные об офисе - координаты для карты, название магазина/бренда, как найти, фото',
            'class' => Office::class,
        ]);
        Setting::create([
            'name' => 'Настройки сайта',
            'slug' => 'web',
            'description' => 'Общие настройки главных цветов, подвала и шапки сайта',
            'class' => Web::class,
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
