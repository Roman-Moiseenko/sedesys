<?php

namespace App\Modules\Service\Service;

use App\Modules\Service\Entity\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Service\Entity\Consumable;
use Illuminate\Support\Facades\DB;

class ConsumableService
{

    public function create(Request $request): Consumable
    {
        DB::transaction(function () use ($request, &$consumable) {
            $consumable = Consumable::register(
                $request->string('name')->trim()->value(),
            );
            $this->save_fields($consumable, $request);
        });

        return $consumable;
    }

    public function update(Consumable $consumable, Request $request)
    {
        $consumable->name = $request->string('name')->trim()->value();
        $consumable->save();

        $this->save_fields($consumable, $request);
    }

    private function save_fields(Consumable $consumable, Request $request)
    {
        $consumable->description = $request->string('description')->trim()->value();
        $consumable->price = $request->integer('price');
        $consumable->count = $request->input('count');
        $consumable->show = $request->boolean('show');
        $consumable->save();

        $consumable->saveImage($request->file('image'), $request->boolean('clear_image'));

    }



    public function destroy(Consumable $consumable)
    {
        /**
         * Проверить на возможность удаления
         */
        $consumable->delete();
    }

    public function attach_service(Consumable $consumable, Request $request)
    {
        //TODO Проверить есть уже или нет.
        $service = Service::find($request->integer('service_id'));
        $consumable->services()
            ->attach(
                $service->id,
                ['count' => $request->integer('count', null)]
            );
        return $service;
    }

    public function detach_service(Consumable $consumable, Request $request)
    {
        $service = Service::find($request->integer('service_id'));
        $consumable->services()->detach($service->id);
        return $service;
    }
}
