<?php

namespace App\Modules\Employee\Service;

use App\Modules\Base\Entity\Meta;
use Illuminate\Http\Request;
use App\Modules\Employee\Entity\Specialization;
use Illuminate\Support\Str;

class SpecializationService
{

    public function create(Request $request): Specialization
    {
        $specialization = Specialization::register(
            $request->string('name')->trim()->value(),
            $request->string('slug')->trim()->value(),
        );

        $this->save_fields($specialization, $request);

        return $specialization;
    }

    public function update(Specialization $specialization, Request $request)
    {
        $specialization->name = $request->string('name')->trim()->value();
        $slug = $request->string('slug')->trim()->value();
        $specialization->slug = empty($slug) ? Str::slug($specialization->name) : $slug;
        $specialization->save();

        $this->save_fields($specialization, $request);
    }

    private function save_fields(Specialization $specialization, Request $request)
    {
        $specialization->meta = Meta::fromRequest($request);
        $specialization->save();

        if ($request->boolean('clear_image') && !is_null($specialization->image)) {
            $specialization->image->delete();
        }
        if ($request->boolean('clear_icon') && !is_null($specialization->icon)) {
            $specialization->icon->delete();
        }

        $this->image($specialization, $request->file('image'));
        $this->icon($specialization, $request->file('icon'));
    }

    public function destroy(Specialization $specialization)
    {
        $specialization->delete();
    }


    private function image(Specialization $specialization, $file): void
    {
        if (empty($file)) return;
        $specialization->image->newUploadFile($file, 'image');
        $specialization->refresh();
    }

    private function icon(Specialization $specialization, $file): void
    {
        if (empty($file)) return;
        $specialization->icon->newUploadFile($file, 'icon');
        $specialization->refresh();
    }

    public function up(Specialization $specialization)
    {
        /** @var Specialization[] $specializations */
        $specializations = Specialization::orderBy('sort')->getModels();
        for ($i = 1; $i < count($specializations); $i++) {
            if ($specializations[$i]->id == $specialization->id) {
                $prev = $specializations[$i - 1]->sort;
                $next = $specializations[$i]->sort;
                $specializations[$i]->setSort($prev);
                $specializations[$i - 1]->setSort($next);
            }
        }
    }

    public function down(Specialization $specialization)
    {
        /** @var Specialization[] $specializations */
        $specializations = Specialization::orderBy('sort')->getModels();
        for ($i = 0; $i < count($specializations) - 1; $i++) {
            if ($specializations[$i]->id == $specialization->id) {
                $prev = $specializations[$i + 1]->sort;
                $next = $specializations[$i]->sort;
                $specializations[$i]->setSort($prev);
                $specializations[$i + 1]->setSort($next);
            }
        }
    }

    public function attach(Specialization $specialization, Request $request)
    {
        $specialization->employees()->detach();
        $employees = $request->input('employees', []);
        foreach ($employees as $employee) {
            $specialization->employees()->attach($employee);
        }
    }
}
