<?php

return [
    'image' => [

        'watermark' => [
            'file' => '/images/watermark.png',
            'size' => 0.2, //от размера изображения
            'position' => 'bottom-right',
            'offset' => 20,
        ],

        'createThumbsOnSave' => true,
        'createThumbsOnRequest' => true,
        'thumbs' => [
            //'mini' => ['width' => 80, 'height' => 80,],
            'thumb' => ['width' => 150, 'height' => 150,],
            //'list' => ['width' => 200, 'height' => 200,],
            //catalog - для списка товаров и категорий
            'catalog' => ['width' => 320, 'height' => 320,],
            //'catalog-watermark' => ['width' => 320, 'height' => 320, 'watermark' => true],
            //Для карточки товара/услуги
            'card' => ['width' => 700, 'height' => 700/*,'watermark' => true*/],
            'original' => []
        ],
        'paths' => [
            'uploads' => '/uploads',
            'cache' => '/cache',
        ],
        'path-uploads' => '/uploads', //del
        'path-cache' => '/cache', //del
        'default' => [
            'Name' => '/images/default-name.png',

        ],//другие параметры
    ],
    'tinymce' => env('TINYMCE', ''),
];
