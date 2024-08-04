<?php

namespace App\Modules\Page\Entity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Deprecated;


class Template
{
    const TEMPLATES = [
        'widget' => 'Виджеты',
        'page' => 'Страницы',
    ];
}
