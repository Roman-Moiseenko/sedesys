<?php

namespace App\Modules\Mail\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Mail\Entity\Outbox;

class OutboxRepository
{

    public function getIndex(Request $request): Arrayable
    {
        $outboxes = Outbox::orderBy('name')
            ->paginate($request->input('size', 20))
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

        return $outboxes;
    }
}
