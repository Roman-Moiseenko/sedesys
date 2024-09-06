<?php

namespace App\Modules\Discount\Service;

use App\Modules\Service\Entity\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Discount\Entity\Promotion;

class PromotionService
{

    public function create(Request $request): Promotion
    {
        /** @var Promotion $promotion */
        $promotion = Promotion::register(
            $request->string('name')->trim()->value(),
            $request->string('slug')->trim()->value(),
        );
        $this->save_fields($promotion, $request);

        return  $promotion;
    }

    public function update(Promotion $promotion, Request $request)
    {
        $promotion->name = $request->string('name')->trim()->value();
        $promotion->setSlug($request->string('slug')->trim()->value());
        $promotion->save();
        $this->save_fields($promotion, $request);
    }

    private function save_fields(Promotion $promotion, Request $request)
    {
        /**
         * Сохраняем оставшиеся поля
         */
        $promotion->saveDisplayed($request);
        //dd($request['range_at']);
        if (is_null($rang_at = $request->input('range_at'))) {
            $promotion->start_at = null;
            $promotion->finish_at = null;
        } else {
            $promotion->start_at = $rang_at[0];
            $promotion->finish_at = $rang_at[1];
        }

        $promotion->description = $request->string('description')->trim()->value();
        $promotion->condition_url = $request->string('condition_url')->trim()->value();
        $promotion->discount = $request->integer('discount');
        $promotion->current = false;

        $promotion->save();
    }


    public function destroy(Promotion $promotion)
    {
        if (!$promotion->isActive()) {
            $promotion->delete();
        } else {
            throw new \DomainException('Нельзя удалить акцию!');
        }
    }

    public function activated(Promotion $promotion)
    {
        if (!is_null($promotion->finish_at) && $promotion->finish_at->lt(now()))
            throw new \DomainException('Нельзя активировать акцию, с датой окончания меньше текущей');
        $promotion->activated();
    }

    public function draft(Promotion $promotion)
    {
        if (!is_null($promotion->finish_at) && $promotion->finish_at->lt(now()))
            throw new \DomainException('Акция завершена, в черновик отправить нельзя');
            $promotion->draft();
    }

    public function start(Promotion $promotion)
    {
        if (!is_null($promotion->finish_at) && $promotion->finish_at->lt(now())) throw new \DomainException('Нельзя запустить акцию, которая завершилась');
        if (!is_null($promotion->start_at)) $promotion->start_at = now();
        $promotion->start();
        $promotion->save();

    }

    public function finish(Promotion $promotion)
    {
        if (!is_null($promotion->finish_at)) $promotion->finish_at = now();
        $promotion->finish();
        $promotion->save();

    }

    public function attach(Promotion $promotion, Request $request)
    {
        /** @var Service $service */
        foreach ($request->input('service_id', []) as $service_id) {
            if (!$promotion->isService($service_id)) {
                $service = Service::find($service_id);

                $promotion->services()->attach($service->id, [
                    'price' => (int)ceil((1 - $promotion->discount / 100) * $service->price)
                ]);
            }
        }
    }

    public function detach(Promotion $promotion, Request $request)
    {
        $promotion->services()->detach($request->integer('service_id'));
    }

    public function set(Promotion $promotion, Request $request)
    {
        $promotion->services()->updateExistingPivot($request->integer('service_id'), ['price' => $request->integer('price')]);
    }


}
