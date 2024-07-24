<?php

namespace App\Modules\Page\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Page\Entity\Widget;

class WidgetService
{

    public function create(Request $request): Widget
    {
        /**
         * Создаем объект с базовыми данными
         */
        $widget = Widget::register(
            (string)$request->string('name')
        );

        $this->save_fields($widget, $request);

        return  $widget;
    }

    public function update(Widget $widget, Request $request)
    {
        /**
         * Сохраняем базовые поля
         */
        $widget->name = (string)$request->string('name');
        $widget->save();

        $this->save_fields($widget, $request);
    }

    private function save_fields(Widget $widget, Request $request)
    {
        /**
         * Сохраняем оставшиеся поля
         */

        $widget->save();
    }


    public function destroy(Widget $widget)
    {
        /**
         * Проверить на возможность удаления
         */
        $widget->delete();
    }
}
