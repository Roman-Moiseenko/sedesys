<?php
declare(strict_types=1);

namespace App\Modules\Web\Repository;

use App\Modules\Base\Entity\BreadcrumbInfo;
use App\Modules\Base\Entity\DisplayedModel;
use App\Modules\Base\Entity\Photo;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Employee\Entity\Specialization;
use App\Modules\Page\Entity\Contact;
use App\Modules\Page\Entity\Page;
use App\Modules\Service\Entity\Classification;
use App\Modules\Service\Entity\Service;
use App\Modules\Setting\Repository\SettingRepository;

class WebRepository
{
    //Модуль Страницы
    public function getContacts(): array
    {
        $contacts = Contact::orderBy('sort')->where('active', true)->get()->map(function (Contact $contact) {
            return [
                'icon' => $contact->icon,
                'image' => '',
                'class' => '',
                'name' => $contact->title,
                'color' => $contact->color,
                'url' => $contact->url,
            ];
        })->toArray();
        return $contacts;
    }

    public function PageBySlug(string $slug): Page
    {
        return Page::where('slug', $slug)->active()->firstOrFail();
    }

    //Модуль Персонал
    public function getEmployees()
    {
        return Employee::orderBy('created_at')->active()->get();
    }

    public function getSpecializations()
    {
        return Specialization::orderBy('sort')->active()->get();
    }

    //Модуль Услуги
    public function getRootClassifications()
    {
        return Classification::active()->where('parent_id', null)->orderBy('_lft')->get();
    }

    public function getServices()
    {
        return Service::active()->orderBy('name')->get();
    }

    //Создаем массив breadcrumb_info из Модели.
    public function getBreadcrumbModel(DisplayedModel $model): array
    {
        return $this->selectBreadcrumb($model->breadcrumb, $model->meta->h1);
    }

    //Выбираем breadcrumb_info из не пустых параметров от Модели, до Default.
    public function selectBreadcrumb(BreadcrumbInfo $breadcrumbInfo, string $meta_h1): array
    {

        $breadcrumb_info = [];
        $web = (new SettingRepository())->getWeb();

        if ($breadcrumbInfo->photo_id == 0) {
            if ($web->default_breadcrumb['photo_id'] != 0) {
                $breadcrumb_info['image'] = (Photo::find($web->default_breadcrumb['photo_id']))->getUploadUrl();
            } else {
                $breadcrumb_info['image'] = '';
            }
        } else {
            $breadcrumb_info['image'] = $breadcrumbInfo->getImage();
        }

        if ($breadcrumbInfo->caption == '' && $meta_h1 == '') {
            $breadcrumb_info['caption'] = $web->default_breadcrumb['caption'];
        } else {
            if ($breadcrumbInfo->caption == '') {
                $breadcrumb_info['caption'] = $meta_h1;
            } else {
                $breadcrumb_info['caption'] = $breadcrumbInfo->caption;
            }
        }

        if ($breadcrumbInfo->description == '') {
            $breadcrumb_info['description'] = $web->default_breadcrumb['description'];
        } else {
            $breadcrumb_info['description'] = $breadcrumbInfo->description;
        }


        return $breadcrumb_info;
    }
}
