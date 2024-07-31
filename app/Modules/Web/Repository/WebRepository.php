<?php
declare(strict_types=1);

namespace App\Modules\Web\Repository;

use App\Modules\Page\Entity\Contact;

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
}
