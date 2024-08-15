<?php

namespace App\Modules\Mail\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Mail\Entity\Inbox;

class InboxRepository
{

    public function getIndex(Request $request, &$filters): Arrayable
    {
        $query = Inbox::orderBy('name');

        $filters = [];

        if ($request->has('email')) {
            $email = $request->string('email')->trim()->value();
            $filters['email'] = $email;
            $query->where('email', 'LIKE', "%$email%");

        }

        if (count($filters) > 0) $filters['count'] = count($filters);

        return $query->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Inbox $inbox) => [
                'id' => $inbox->id,
                'name' => $inbox->name,
                /**
                 */

                'url' => route('admin.mail.inbox.show', $inbox),
                'edit' => route('admin.mail.inbox.edit', $inbox),
                'destroy' => route('admin.mail.inbox.destroy', $inbox),

            ]);

    }
}
