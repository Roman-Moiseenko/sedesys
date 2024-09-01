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
        $specialization->setSlug($request->string('slug')->trim()->value());
        $specialization->save();

        $this->save_fields($specialization, $request);
    }

    private function save_fields(Specialization $specialization, Request $request)
    {

        $specialization->saveDisplayed($request);

        $this->attach($specialization, $request);

    }

    public function destroy(Specialization $specialization)
    {
        $specialization->delete();
    }

    public function up(Specialization $specialization)
    {
        /** @var Specialization[] $specializations */
        $specializations = Specialization::orderBy('sort')->getModels();
        up($specialization, $specializations);
    }

    public function down(Specialization $specialization)
    {
        /** @var Specialization[] $specializations */
        $specializations = Specialization::orderBy('sort')->getModels();
        down($specialization, $specializations);
    }

    public function attach(Specialization $specialization, Request $request)
    {
        $specialization->employees()->detach();
        $employees = $request->input('employees', []);
        foreach ($employees as $employee) {
            $specialization->employees()->attach($employee);
        }
    }

    public function detach(Specialization $specialization, Request $request)
    {
        $specialization->employees()->detach($request->integer('employee_id'));
    }
}
