<?php

namespace App\Modules\Service\Repository;

use App\Modules\Service\Entity\Service;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Service\Entity\Consumable;

class ConsumableRepository
{

    public function getIndex(Request $request, &$filters): Arrayable
    {
        $query = Consumable::orderBy('name');
        $filters = [];
        if ($request->has('name')) {
            $name = $request->string('name')->trim()->value();
            $filters['name'] = $name;
            $query->where('name', 'LIKE', "%$name%");
        }

        if (count($filters) > 0) $filters['count'] = count($filters); //Кол-во выбранных элементов в поиске
        return $query->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Consumable $consumable) => $this->ConsumableToArray($consumable));
    }


    public function ConsumableToArray(Consumable $consumable): array
    {
        return [
            'id' => $consumable->id,
            'name' => $consumable->name,
            'price' => $consumable->price,
            'count' => $consumable->count,
            'description' => $consumable->description,
            'active'  => $consumable->isActive(),
            'show' => $consumable->isShow(),
            'count_services' => $consumable->services()->count(),
            'image' => $consumable->getImage(),
        ];
    }

    public function ConsumableWithToArray(Consumable $consumable): array
    {
        $withData = [
            'services' => $consumable->services()->get()->map(
                fn(Service $service) => [
                    'id' => $service->id,
                    'name' => $service->name,
                    'count' => $service->pivot->count,
                    'price' => $service->price,
                    'consumables' => $service->consumables()->get()->map(fn($item) => $item->name)->toArray(),
                ]
            )->toArray(),
        ];

        return array_merge($this->ConsumableToArray($consumable), $withData);
    }

    public function outServices(Consumable $consumable)
    {
        $ids = $consumable->services()->pluck('id')->toArray();

        return Service::whereNotIn('id', $ids)->getModels();
    }

    public function getShowByService(Service $service): array
    {
        return $service->consumables()->get()->map(function (Consumable $consumable) {
            return $this->ConsumableToArray($consumable);
        })->toArray();
    }
}
