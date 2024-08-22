<?php

namespace App\Modules\Service\Service;

use App\Modules\Base\Entity\Meta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Service\Entity\Classification;
use Illuminate\Support\Str;

class ClassificationService
{

    public function create(Request $request): Classification
    {
        /**
         * Создаем объект с базовыми данными
         */
        //dd($request->all());
        $classification = Classification::register(
            $request->string('name')->trim()->value(),
            $request->integer('parent_id', null),
            $request->string('slug')->trim()->value(),
        );

        $this->save_fields($classification, $request);

        return  $classification;
    }

    public function update(Classification $classification, Request $request)
    {
        $classification->name = $request->string('name')->trim()->value();
        $classification->parent_id = $request->integer('parent_id', null);
        $slug = $request->string('slug')->trim()->value();
        $classification->slug = empty($slug) ? Str::slug($classification->name) : $slug;
        $classification->save();

        $this->save_fields($classification, $request);
    }



    public function destroy(Classification $classification)
    {
        $classification->delete();
    }

    //TODO Перенести в Trait ModelPage Интерфейс ()
    private function save_fields(Classification $classification, Request $request)
    {
        $classification->meta = Meta::fromRequest($request);
        $classification->save();

        if ($request->boolean('clear_image') && !is_null($classification->image)) {
            $classification->image->delete();
        }
        if ($request->boolean('clear_icon') && !is_null($classification->icon)) {
            $classification->icon->delete();
        }

        $this->image($classification, $request->file('image'));
        $this->icon($classification, $request->file('icon'));
    }

    private function image(Classification $classification, $file): void
    {
        if (empty($file)) return;
        $classification->image->newUploadFile($file, 'image');
        $classification->refresh();
    }

    private function icon(Classification $classification, $file): void
    {
        if (empty($file)) return;
        $classification->icon->newUploadFile($file, 'icon');
        $classification->refresh();
    }
}
