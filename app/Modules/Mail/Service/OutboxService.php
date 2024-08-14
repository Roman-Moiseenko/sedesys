<?php

namespace App\Modules\Mail\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Mail\Entity\Outbox;

class OutboxService
{

    public function create(Request $request): Outbox
    {
        /**
         * Создаем объект с базовыми данными
         */
        $outbox = Outbox::register(
            $request->string('name')->trim()->value(),
        );

        $this->save_fields($outbox, $request);

        return  $outbox;
    }

    public function update(Outbox $outbox, Request $request)
    {
        /**
         * Сохраняем базовые поля
         */
        $outbox->name = $request->string('name')->trim()->value();
        $outbox->save();

        $this->save_fields($outbox, $request);
    }

    private function save_fields(Outbox $outbox, Request $request)
    {
        /**
         * Сохраняем оставшиеся поля
         */

        $outbox->save();
    }


    public function destroy(Outbox $outbox)
    {
        /**
         * Проверить на возможность удаления
         */
        $outbox->delete();
    }
}
