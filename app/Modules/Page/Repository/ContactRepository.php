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

                'url' => route('admin.page.contact.show', $contact),
                'edit' => route('admin.page.contact.edit', $contact),
                'destroy' => route('admin.page.contact.destroy', $contact),
                'toggle' => route('admin.page.contact.toggle', $contact),

                'up' => route('admin.page.contact.up', $contact),
                'down' => route('admin.page.contact.down', $contact),
            ]);
    }
}
