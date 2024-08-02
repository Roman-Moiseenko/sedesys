<?php
declare(strict_types=1);

namespace App\Modules\Web\Repository;

use App\Modules\Employee\Entity\Employee;
use App\Modules\Page\Entity\Contact;
use App\Modules\Page\Entity\Page;

class WebRepository
{
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

    public function getEmployees()
    {
        $employees = Employee::orderBy('created_at')->where('active', true)->get();
        return $employees;
    }
}