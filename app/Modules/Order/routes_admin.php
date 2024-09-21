<?php

use App\Modules\Order\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'order',
        'as' => 'order.',
    ],
    function () {
        Route::group(
            [
                'prefix' => 'order',
                'as' => 'order.',
                'controller'=> 'OrderController',
            ],
            function () {
                Route::post('/create-staff', 'create_staff')->name('create-staff');
                //Работа с Заказом
                Route::post('/{order}/add-item', 'add_item')->name('add-item');
                Route::post('/{order}/del-item', 'del_item')->name('del-item');
                Route::post('/{order}/set-item', 'set_item')->name('set-item');
                Route::post('/{order}/set-user', 'set_user')->name('set-user');

                //Действия с Заказом
                Route::post('/{order}/awaiting', 'awaiting')->name('awaiting');
                Route::post('/{order}/cancel', 'cancel')->name('cancel');
                Route::post('/{order}/paid', 'paid')->name('paid');
                Route::post('/{order}/cheque', 'cheque')->name('cheque');

            });


        Route::Resource('order', 'OrderController');
        Route::Resource('payment', 'OrderPaymentController');
    }
);



