<?php

namespace App\Modules\Service\Service;

use App\Modules\Base\Entity\Meta;
use App\Modules\Base\Entity\Photo;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Service\Entity\Consumable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Service\Entity\Service;
use Illuminate\Support\Str;

class ServiceService
{

    public function create(Request $request): Service
    {

        $service = Service::register(
            $request->string('name')->trim()->value(),
            $request->string('slug')->trim()->value(),
        );

        $this->save_fields($service, $request);

        return  $service;
    }

    public function update(Service $service, Request $request)
    {
        $service->name = $request->string('name')->trim()->value();
        $service->setSlug($request->string('slug')->trim()->value());
        $service->save();

        $this->save_fields($service, $request);
    }

    private function save_fields(Service $service, Request $request)
    {
        $service->saveDisplayed($request);

        $service->price = $request->integer('price', null);
        $service->duration = $request->integer('duration', null);
        $service->data = $request->string('data')->trim()->value();

        $service->classification_id = $request->integer('classification_id', null);
        $service->save();
    }


    public function destroy(Service $service)
    {
        /**
         * Проверить на возможность удаления
         */
        $service->delete();
    }


    public function addPhoto(Service $service, Request $request)
    {
        $service->addImage($request->file('file'));
      /*  if (empty($file = $request->file('file'))) throw new \DomainException('Нет файла');

        $sort = count($service->gallery);
        $service->gallery()->save(Photo::upload($file, 'gallery', $sort));*/
    }

    public function delPhoto(Service $service, Request $request)
    {
        $service->delImage($request->integer('photo_id'));
       /* $photo = Photo::find($request->integer('photo_id'));
        $photo->delete();
        foreach ($service->gallery as $i => $photo) {
            $photo->update(['sort' => $i]);
        }*/
    }

    public function setAlt(Service $service, Request $request)
    {
        $service->setAlt(
            photo_id: $request->integer('photo_id'),
            alt: $request->string('alt')->trim()->value(),
            title: $request->string('title')->trim()->value(),
            description: $request->string('description')->trim()->value(),
        );

        /*$id = $request->integer('photo_id');
        foreach ($service->gallery as $photo) {
            if ($photo->id === $id) {
                $photo->update([
                    'alt' => $request->string('alt')->trim()->value(),
                    'title' => $request->string('title')->trim()->value(),
                    'description' => $request->string('description')->trim()->value(),
                ]);
            }
        }*/
    }

    public function attach_employee(Service $service, Request $request)
    {
        //TODO Проверить есть уже или нет.

        $employee = Employee::find($request->integer('employee_id'));
        $extra_cost = $request->integer('extra_cost');
        $service->employees()->attach($employee->id, ['extra_cost' => $extra_cost]);
        return $employee;
    }

    public function detach_employee(Service $service, Request $request)
    {
        $employee = Employee::find($request->integer('employee_id'));
        $service->employees()->detach($employee->id);
        return $employee;
    }

    public function attach_consumable(Service $service, Request $request)
    {
        $consumable = Consumable::find($request->integer('consumable_id'));
        $count = $request->integer('count');
        $service->consumables()->attach($consumable->id, ['count' => $count]);
        return $consumable;
    }

    public function detach_consumable(Service $service, Request $request)
    {
        $consumable = Consumable::find($request->integer('consumable_id'));
        $service->consumables()->detach($consumable->id);
        return $consumable;
    }
}
