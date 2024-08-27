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
            $request->string('slug')->trim()->value(),
        );

        $this->save_fields($classification, $request);

        return  $classification;
    }

    public function update(Classification $classification, Request $request)
    {
        $classification->name = $request->string('name')->trim()->value();
        $classification->setSlug($request->string('slug')->trim()->value());
        $classification->save();

        $this->save_fields($classification, $request);
    }


    public function destroy(Classification $classification)
    {
        $classification->delete();
    }

    private function save_fields(Classification $classification, Request $request)
    {
        $classification->saveDisplayed($request);

        $classification->parent_id = $request->integer('parent_id', null);
        $classification->save();
    }

}
