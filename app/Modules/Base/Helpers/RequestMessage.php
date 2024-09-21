<?php
declare(strict_types=1);

namespace App\Modules\Base\Helpers;

class RequestMessage
{
    public static function messages()
    {
        return [
            'service_id.required' => 'Не выбрана услуга',
            'employee_id.required' => 'Не выбран специалист',
            'extra_id.required' => 'Не выбрана доп.услуга',
            'consumable_id.required' => 'Не выбран расходный материал',

            'quantity.required' => 'Не указано количество',
            'quantity.min' => 'Минимальное значение 1',
        ];
    }

}
