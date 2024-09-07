<?php

namespace App\Modules\Discount\Repository;

use App\Modules\Service\Entity\Classification;
use App\Modules\Service\Entity\Service;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Discount\Entity\Promotion;

class PromotionRepository
{

    public function getIndex(Request $request, &$filters): Arrayable
    {
        $query = Promotion::orderBy('name');
        /**
         * Фильтр, для каждого параметра своя проверка
         */
        $filters = [];
        if ($request->has('name')) {
            $name = $request->string('name')->trim()->value();
            $filters['name'] = $name;
            $query->where('name', 'LIKE', "%$name%");
        }
        if ($request->has('status')) {
            $status = $request->integer('status');
            $filters['status'] = $status;
            if ($status == Promotion::STATUS_STARTED) {
                $query->where('current', true);
            }
            if ($status == Promotion::STATUS_DRAFT) {
                $query->where('active', false)->where('current', false);
            }
            if ($status == Promotion::STATUS_FINISHED) {
                $query->where('active', true)->where('current', false)->where('finish_at', '<>', null)->where('finish_at', '<', now());
            }
            if ($status == Promotion::STATUS_WAITING) {
                $query->where('active', true)->where('current', false)->where(function ($query) {
                    $query->where('finish_at', null)->orWhere('start_at', '>', now());
                });
            }
        }
        if ($request->has('service')) {
            $service = $request->integer('service');
            $filters['service'] = $service;
                $query->whereHas('services', function ($query) use ($service) {
                    $query->where('id', $service);
                });
        }
        if (count($filters) > 0) $filters['count'] = count($filters); //Кол-во выбранных элементов в поиске
        return $query->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Promotion $promotion) => $this->PromotionToArray($promotion));
    }


    public function PromotionToArray(Promotion $promotion): array
    {
        return [
            'id' => $promotion->id,
            'name' => $promotion->name,
            'services' => $promotion->services()->get()->map(function (Service $service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                ];
            })->toArray(),
            'schedule' => $promotion->isSchedule(),
            'active' => $promotion->isActive(),
            'current' => $promotion->isCurrent(),
            'status' => $promotion->statusText(),
            'start_at' => $promotion->getStartAt(),
            'finish_at' => $promotion->getFinishAt(),
            'discount' => $promotion->discount,
            'items' => $promotion->items()->count(),

            'url' => route('admin.discount.promotion.show', $promotion),
            'edit' => route('admin.discount.promotion.edit', $promotion),
            'destroy' => route('admin.discount.promotion.destroy', $promotion),
            'toggle' => route('admin.discount.promotion.toggle', $promotion),
            'start' => route('admin.discount.promotion.start', $promotion),

            'finish' => route('admin.discount.promotion.finish', $promotion),


        ];
    }

    public function outServices(Promotion $promotion)
    {
        $ids = $promotion->services()->pluck('id')->toArray();

        return Service::whereNotIn('id', $ids)->getModels();
    }

    public function getStatuses()
    {
        return array_select(Promotion::STATUSES);
    }

    public function getGroupStatuses()
    {
        /** @var Classification[] $classifications */
        $result = [];
        $classifications = Classification::get();
        foreach ($classifications as $classification) {
            if (!is_null($classification->services)) {
                $result[] = [
                    'label' => $classification->name,
                    'options' => $classification->services()->get()->map(function (Service $service) {
                        return [
                            'value' => $service->id,
                            'label' => $service->name,
                        ];
                    })->toArray(),
                ];
            }
        }
        return $result;
    }
}
