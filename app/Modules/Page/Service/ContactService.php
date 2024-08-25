<?php

namespace App\Modules\Page\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Page\Entity\Contact;

class ContactService
{

    public function create(Request $request): Contact
    {
        $contact = Contact::register(
            (string)$request->string('name')
        );
        $sort = Contact::get()->count();
        $contact->setSort($sort);
        $this->save_fields($contact, $request);
        return  $contact;
    }

    public function update(Contact $contact, Request $request)
    {
        $contact->name = (string)$request->string('name');
        $contact->save();

        $this->save_fields($contact, $request);
    }

    private function save_fields(Contact $contact, Request $request)
    {
        $contact->icon = $request->string('icon')->trim()->value();
        $contact->url = $request->string('url')->trim()->value();
        $contact->color = $request->string('color')->trim()->value();
        $contact->title = $request->string('title')->trim()->value();

        $contact->save();
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
    }

    public function toggle(Contact $contact): bool
    {
        if ($contact->isActive()) {
            $contact->draft();
        } else {
            $contact->activated();
        }
        $contact->refresh();
        return $contact->isActive();
    }

    public function up(Contact $contact)
    {
        /** @var Contact[] $contacts */
        $contacts = Contact::orderBy('sort')->getModels();
        for ($i = 1; $i < count($contacts); $i++) {
            if ($contacts[$i]->id == $contact->id) {
                $prev = $contacts[$i - 1]->sort;
                $next = $contacts[$i]->sort;
                $contacts[$i]->setSort($prev);
                $contacts[$i - 1]->setSort($next);
            }
        }
    }

    public function down(Contact $contact)
    {
        /** @var Contact[] $contacts */
        $contacts = Contact::orderBy('sort')->getModels();
        for ($i = 0; $i < count($contacts) - 1; $i++) {
            if ($contacts[$i]->id == $contact->id) {
                $prev = $contacts[$i + 1]->sort;
                $next = $contacts[$i]->sort;
                $contacts[$i]->setSort($prev);
                $contacts[$i + 1]->setSort($next);
            }
        }
    }
}
