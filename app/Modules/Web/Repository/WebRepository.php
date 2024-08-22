<?php
declare(strict_types=1);

namespace App\Modules\Web\Repository;

use App\Modules\Employee\Entity\Employee;
use App\Modules\Employee\Entity\Specialization;
use App\Modules\Page\Entity\Contact;
use App\Modules\Page\Entity\Page;
use App\Modules\Service\Entity\Classification;

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
        return Page::where('slug', $slug)->where('published', true)->firstOrFail();
    }

    //Модуль Персонал
    public function getEmployees()
    {
        return Employee::orderBy('created_at')->where('active', true)->get();
    }

    public function getSpecializations()
    {
        return Specialization::orderBy('sort')->where('active', true)->get();
    }

    //Модуль Услуги
    public function getRootClassifications()
    {
        return Classification::where('parent_id', null)->orderBy('_lft')->get();
    }
}
