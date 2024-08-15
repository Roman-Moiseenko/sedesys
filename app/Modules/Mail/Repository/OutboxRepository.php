<?php

namespace App\Modules\Mail\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Mail\Entity\Outbox;

class OutboxRepository
{

    public function getIndex(Request $request, &$filters): Arrayable
    {
        $query = Outbox::orderBy('name');
        $filters = [];

        if ($request->has('email')) {
            $email = $request->string('email')->trim()->value();
            $filters['email'] = $email;
            $query->where('email', 'LIKE', "%$email%");

        }
        //TODO Тип сотрудника
        if (count($filters) > 0) $filters['count'] = count($filters);
        return $query->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Outbox $outbox) => [
                'id' => $outbox->id,
                'name' => $outbox->name,
                /**
                 */

                'url' => route('admin.mail.outbox.show', $outbox),
                'edit' => route('admin.mail.outbox.edit', $outbox),
                'destroy' => route('admin.mail.outbox.destroy', $outbox),

            ]);

    }
}
