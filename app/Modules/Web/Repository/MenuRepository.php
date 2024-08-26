<?php
declare(strict_types=1);

namespace App\Modules\Web\Repository;

use App\Modules\Service\Entity\Classification;
use App\Modules\Service\Entity\Service;

class MenuRepository
{
    public function classifications($parent_id = null): array
    {
        /** @var Classification[] $classifications */
        $classifications = Classification::orderBy('_lft')->where('parent_id', $parent_id)->active()->get();
        $result = [];
        foreach ($classifications as $classification) {

            $result[$classification->id] = [
                'icon' => $classification->getIcon('mini'),
                //'image' => '',
                'name' => $classification->name,
            ];

            if ($classification->children()->count() > 0) {
                $result[$classification->id]['submenu'] = $this->classifications($classification->id);
            } else {
                $result[$classification->id]['url'] = route('web.classification.view', $classification->slug);
            }
        }
        return $result;
    }

    public function services(int $classification_id = null): array
    {
        $query = Service::orderBy('name')->active();
        if (!is_null($classification_id)) $query->where('classification_id', $classification_id);
        $services = $query->get();
        $result = [];
        foreach ($services as $service) {
            $result[$service->id] = [
                'icon' => $service->getIcon('mini'),
                //'image' => '',
                'name' => $service->name,
                'url' =>  route('web.service.view', $service->slug),
            ];
        }
        return $result;
    }

    public function classification_services(): array
    {
        /** @var Classification[] $classifications */
        $classifications = Classification::orderBy('_lft')->where('parent_id', null)->active()->get();
        $result = [];
        foreach ($classifications as $classification) {

            $result[$classification->id] = [
                'icon' => $classification->getIcon('mini'),
                //'image' => '',
                'name' => $classification->name,
            ];

            if ($classification->services()->count() > 0) {
                //dd($classification->services);
                $result[$classification->id]['submenu'] = $this->services($classification->id);
            } else {
                $result[$classification->id]['url'] = route('web.classification.view', $classification->slug);
            }
        }
        return $result;
    }
}
