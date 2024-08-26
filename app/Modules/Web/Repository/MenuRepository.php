<?php
declare(strict_types=1);

namespace App\Modules\Web\Repository;

use App\Modules\Employee\Entity\Employee;
use App\Modules\Employee\Entity\Specialization;
use App\Modules\Page\Entity\Page;
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
            $key = 'class_' . $classification->id;
            $result[$key] = [
                'image' => $classification->getIcon('mini'),
                //'icon' => '',
                'name' => $classification->name,
                'url' => route('web.classification.view', $classification->slug),
            ];
            if ($classification->children()->count() > 0)
                $result[$key]['submenu'] = $this->classifications($classification->id);
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
            $key = 'service_' . $service->id;
            $result[$key] = [
                'image' => $service->getIcon('mini'),
                //'icon' => '',
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
            $key = 'class_service_' . $classification->id;
            $result[$key] = [
                'image' => $classification->getIcon('mini'),
                //'icon' => '',
                'name' => $classification->name,
                'url' => route('web.classification.view', $classification->slug),
            ];
            if ($classification->services()->count() > 0)
                $result[$key]['submenu'] = $this->services($classification->id);
        }
        return $result;
    }

    public function employees(int $specialization_id = null):array
    {
        $query = Employee::orderBy('created_at')->active();
        if (!is_null($specialization_id)) $query->whereHas('specializations', function ($q) use($specialization_id) {
            $q->where('specialization_id', $specialization_id);
        });
        $employees = $query->get();
        $result = [];
        foreach ($employees as $employee) {
            $key = 'employee' . $employee->id;
            $result[$key] = [
                'image' => $employee->getIcon('mini'),
                //'icon' => '',
                'name' => $employee->fullname->getFullName(),
                'url' =>  route('web.employee.view', $employee),
            ];
        }
        return $result;
    }

    public function specializations(): array
    {
        $specializations = Specialization::orderBy('sort')->active()->get();
        $result = [];
        foreach ($specializations as $specialization) {
            $key = 'special_' . $specialization->id;
            $result[$key] = [
                'image' => $specialization->getIcon('mini'),
                //'icon' => '',
                'name' => $specialization->name,
                'url' =>  route('web.specialization.view', $specialization->slug),
            ];
        }
        return $result;
    }

    public function specialization_employees(): array
    {
        $specializations = Specialization::orderBy('sort')->active()->get();
        $result = [];
        foreach ($specializations as $specialization) {
            $key = 'special_employee_' . $specialization->id;
            $result[$key] = [
                'image' => $specialization->getIcon('mini'),
                //'icon' => '',
                'name' => $specialization->name,
                'url' =>  route('web.specialization.view', $specialization->slug),
                'submenu' => $this->employees($specialization->id),
            ];
        }
        return $result;
    }

    public function pages(int $parent_id = null): array
    {
        $pages = Page::orderBy('_lft')->where('parent_id', $parent_id)->active()->get();
        $result = [];
        foreach ($pages as $page) {
            $key = 'page_' . $page->id;
            $result[$key] = [
                'image' => $page->getIcon('mini'),
                //'icon' => '',
                'name' => $page->name,
                'url' => route('web.page.view', $page->slug),
            ];
            if ($page->children()->count() > 0)
                $result[$key]['submenu'] = $this->pages($page->id);
        }
        return $result;
    }
}
