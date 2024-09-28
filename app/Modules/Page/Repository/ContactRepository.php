<?php

namespace App\Modules\Page\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Page\Entity\Contact;

class ContactRepository
{

    public function getIndex(Request $request): Arrayable
    {
        return Contact::orderBy('sort')
            ->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Contact $contact) => [
                'id' => $contact->id,
                'name' => $contact->name,
                'active' => $contact->isActive(),
                'title' => $contact->title,
                'icon' => $contact->icon,
                'color' => $contact->color,
                'link' => $contact->url,
            ]);
    }
}
