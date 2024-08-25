<?php

namespace App\Modules\Service\Service;

use App\Modules\Base\Entity\Photo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Service\Entity\Example;

class ExampleService
{

    public function create(Request $request): Example
    {
        $example = Example::register(
            $request->integer('service_id'),
        );
        $this->save_fields($example, $request);

        return  $example;
    }

    public function update(Example $example, Request $request)
    {
        $example->service_id = $request->integer('service_id');
        $example->save();

        $this->save_fields($example, $request);
    }

    private function save_fields(Example $example, Request $request)
    {
        $example->title = $request->string('title')->trim()->value();
        $example->description = $request->string('description')->trim()->value();
        $example->duration = $request->string('duration')->trim()->value();
        $example->date = $request->date('date');
        $example->cost = $request->integer('cost');

        $example->employees()->detach();
        $employees = $request->input('employees', []);

        foreach ($employees as $employee) {
            $example->employees()->attach($employee);
        }
        $example->save();
    }

    public function destroy(Example $example)
    {
        $example->delete();
    }

    public function addPhoto(Example $example, Request $request)
    {
        if (empty($file = $request->file('file'))) throw new \DomainException('Нет файла');

        $sort = count($example->gallery);
        $example->gallery()->save(Photo::upload($file, '', $sort));
    }

    public function delPhoto(Example $example, Request $request)
    {
        $photo = Photo::find($request->integer('photo_id'));
        $photo->delete();
        foreach ($example->gallery as $i => $photo) {
            $photo->update(['sort' => $i]);
        }
    }

    public function setAlt(Example $example, Request $request)
    {
        $id = $request->integer('photo_id');
        foreach ($example->gallery as $photo) {
            if ($photo->id === $id) {
                $photo->update([
                    'alt' => $request->string('alt')->trim()->value(),
                    'title' => $request->string('title')->trim()->value(),
                    'description' => $request->string('description')->trim()->value(),
                ]);
            }
        }
    }
}
