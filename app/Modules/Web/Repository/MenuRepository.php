<?php
declare(strict_types=1);

namespace App\Modules\Web\Repository;

use App\Modules\Base\Entity\DisplayedModel;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Employee\Entity\Specialization;
use App\Modules\Page\Entity\Page;
use App\Modules\Service\Entity\Classification;
use App\Modules\Service\Entity\Service;
use App\Modules\Setting\Entity\Web;
use App\Modules\Setting\Repository\SettingRepository;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\select;

class MenuRepository
{
    private Web $web;

    public function __construct()
    {
        $this->web = (new SettingRepository())->getWeb();
    }

    public function classifications($parent_id = null): array
    {
        /** @var Classification[] $classifications */
        $classifications = Classification::orderBy('_lft')->where('parent_id', $parent_id)->active()->get();
        $result = [];
        foreach ($classifications as $classification) {
            $key = 'class_' . $classification->id;
            $result[$key] = [
                'icon' => $this->icon($classification),
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
                'icon' => $this->icon($service),
                'name' => $service->name,
                'url' => route('web.service.view', $service->slug),
            ];
        }
        return $result;
    }

    public function classification_services($parent_id = null): array
    {
        /** @var Classification[] $classifications */
        $classifications = Classification::orderBy('_lft')->where('parent_id', $parent_id)->active()->get();
        $result = [];
        foreach ($classifications as $classification) {
            $key = 'class_service_' . $classification->id;
            $result[$key] = [
                'icon' => $this->icon($classification),
                'name' => $classification->name,
                'url' => route('web.classification.view', $classification->slug),
            ];

            if ($classification->children()->count() > 0) {
                $result[$key]['submenu'] = $this->classification_services($classification->id);
            } elseif ($classification->services()->count() > 0)
                $result[$key]['submenu'] = $this->services($classification->id);
        }
        return $result;
    }

    public function employees(int $specialization_id = null): array
    {
        $query = Employee::orderBy('created_at')->active();
        if (!is_null($specialization_id)) $query->whereHas('specializations', function ($q) use ($specialization_id) {
            $q->where('specialization_id', $specialization_id);
        });
        $employees = $query->get();
        $result = [];
        foreach ($employees as $employee) {
            $key = 'employee' . $employee->id;
            $result[$key] = [
                'icon' => '', //TODO $this->icon($employee),
                'name' => $employee->fullname->getFullName(),
                'url' => route('web.employee.view', $employee),
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
                'icon' => $this->icon($specialization),
                'name' => $specialization->name,
                'url' => route('web.specialization.view', $specialization->slug),
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
                'icon' => $this->icon($specialization),
                'name' => $specialization->name,
                'url' => route('web.specialization.view', $specialization->slug),
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
                'icon' => $this->icon($page),
                'name' => $page->name,
                'url' => route('web.page.view', $page->slug),
            ];
            if ($page->children()->count() > 0)
                $result[$key]['submenu'] = $this->pages($page->id);
        }
        return $result;
    }

    public function page(int $id): array
    {
        //TODO Сделать настройку url для родительской страницы - показывать или нет
        $page = Page::find($id);
        return [
            'icon' => '',
            'name' => $page->name,
            'url' => route('web.page.view', $page->slug),
            'submenu' => $this->pages($id),
        ];
    }


    private function icon(DisplayedModel $model): string
    {

        if ($this->web->menu_icon == 'icon') {
            $src = $model->getIcon('mini');
            return empty($src) ? '' : '<img src="' . $src . '" class="top-menu-icon" />';
        }
        if ($this->web->menu_icon == 'awesome')
            return $model->getAwesome();

        return '';
    }
/*
    private function iconRaw($class, $id, $awesome): string
    {

        if ($this->web->menu_icon == 'icon') {
            $icon = DB::select("select * from photos where imageable_type = :model_class and imageable_id = :model_id and `type` = 'icon' ",
                ['model_class' => $class, 'model_id' => $id]);
            $path = '';
            return '<img src="' . $path . '" class="top-menu-icon" />';
        }
        if ($this->web->menu_icon == 'awesome') {
            if (empty($awesome)) return '';
            return '<i class="' . $awesome . '"></i>';
        }


        return '';
    }

    */
}
