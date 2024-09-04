<?php

namespace App\Modules\Calendar\Service;

use App\Modules\Service\Entity\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Calendar\Entity\Rule;

class RuleService
{

    public function create(Request $request): Rule
    {
        $rule = Rule::register(
            $request->string('name')->trim()->value(),
            $request->integer('regularity'),
        );
        $this->save_fields($rule, $request);
        return  $rule;
    }

    public function update(Rule $rule, Request $request)
    {
        $rule->name = $request->string('name')->trim()->value();
        $rule->regularity = $request->integer('regularity');
        $rule->save();
        $this->save_fields($rule, $request);
    }

    private function save_fields(Rule $rule, Request $request)
    {
        $rule->max = $request->integer('max');
        $rule->save();
        $services = $request->input('services', []);
        $rule->services()->detach();
        foreach ($services as $service) {
            $empty = Rule::where('regularity', $rule->regularity)
                ->whereHas('services', function ($q) use ($service) {
                    $q->where('id', $service);
                })
                ->first();
            if (!is_null($empty)) {
                //TODO получить название услуги и даты
                throw new \DomainException('Услуга уже добавлена в другое правило с тем же типом даты');
            }
            $rule->services()->attach($service);
        }
        $employees = $request->input('employees', []);
        $rule->employees()->detach();
        foreach ($employees as $employee) {
            $rule->employees()->attach($employee);
        }

        $rule->save();
    }

    public function destroy(Rule $rule)
    {
        $rule->delete();
    }


}
