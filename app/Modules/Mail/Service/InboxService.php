<?php

namespace App\Modules\Mail\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Mail\Entity\Inbox;

class InboxService
{

    public function create(Request $request): Inbox
    {
        /**
         * Создаем объект с базовыми данными
         */
        $inbox = Inbox::register(
            $request->string('name')->trim()->value(),
        );

        $this->save_fields($inbox, $request);

        return  $inbox;
    }

    public function update(Inbox $inbox, Request $request)
    {
        /**
         * Сохраняем базовые поля
         */
        $inbox->name = $request->string('name')->trim()->value();
        $inbox->save();

        $this->save_fields($inbox, $request);
    }

    private function save_fields(Inbox $inbox, Request $request)
    {
        /**
         * Сохраняем оставшиеся поля
         */

        $inbox->save();
    }


    public function destroy(Inbox $inbox)
    {
        /**
         * Проверить на возможность удаления
         */
        $inbox->delete();
    }
}
