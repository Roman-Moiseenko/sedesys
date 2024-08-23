<?php

namespace App\Modules\Service\Service;

use App\Modules\Base\Entity\Meta;
use App\Modules\Base\Entity\Photo;
use App\Modules\Employee\Entity\Employee;
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
            $request->input('classification_id', null),
            $request->string('slug')->trim()->value(),
        );

        $this->save_fields($service, $request);

        return  $service;
    }

    public function update(Service $service, Request $request)
    {
        $service->name = $request->string('name')->trim()->value();
        $service->classification_id = $request->integer('classification_id', null);
        $slug = $request->string('slug')->trim()->value();
        $service->slug = empty($slug) ? Str::slug($service->name) : $slug;
        $service->save();

        $this->save_fields($service, $request);
    }

    private function save_fields(Service $service, Request $request)
    {
        /**
         * Сохраняем оставшиеся поля
         */
        $service->template = $request->string('template')->value();
        $service->price = $request->integer('price', null);
        $service->duration = $request->integer('duration', null);

        $service->text = $request->string('text')->trim()->value();
        $service->data = $request->string('data')->trim()->value();

        $service->meta = Meta::fromRequest($request);

        $service->save();

        if ($request->boolean('clear_image') && !is_null($service->image)) {
            $service->image->delete();
        }
        if ($request->boolean('clear_icon') && !is_null($service->icon)) {
            $service->icon->delete();
        }

        $this->image($service, $request->file('image'));
        $this->icon($service, $request->file('icon'));
    }


    public function destroy(Service $service)
    {
        /**
         * Проверить на возможность удаления
         */
        $service->delete();
    }

    private function image(Service $service, $file): void
    {
        if (empty($file)) return;
        $service->image->newUploadFile($file, 'image');
        $service->refresh();
    }

    private function icon(Service $service, $file): void
    {
        if (empty($file)) return;
        $service->icon->newUploadFile($file, 'icon');
        $service->refresh();
    }

    public function addPhoto(Service $service, Request $request)
    {
        if (empty($file = $request->file('file'))) throw new \DomainException('Нет файла');

        $sort = count($service->gallery);
        $service->gallery()->save(Photo::upload($file, 'gallery', $sort));
    }

    public function delPhoto(Service $service, Request $request)
    {
        $photo = Photo::find($request->integer('photo_id'));
        $photo->delete();
        foreach ($service->gallery as $i => $photo) {
            $photo->update(['sort' => $i]);
        }
    }

    public function setAlt(Service $service, Request $request)
    {
        $id = $request->integer('photo_id');
        foreach ($service->gallery as $photo) {
            if ($photo->id === $id) {
                $photo->update([
                    'alt' => $request->string('alt')->trim()->value(),
                    'title' => $request->string('title')->trim()->value(),
                    'description' => $request->string('description')->trim()->value(),
                ]);
            }
        }
    }

    public function attach_employee(Service $service, Request $request)
    {
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
}
