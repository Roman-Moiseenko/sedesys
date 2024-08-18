<?php

namespace App\Modules\Mail\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Mail\Entity\Inbox;

class InboxRepository
{

    public function getIndex(Request $request, &$filters): Arrayable
    {
        $query = Inbox::orderByDesc('created_at');

        $filters = [];

        if ($request->has('email')) {
            $email = $request->string('email')->trim()->value();
            $filters['email'] = $email;
            $query->where('email', 'LIKE', "%$email%");
        }
        if ($request->input('read', 'false') == 'true' ) {
            $filters['read'] = 'true';
            $query->where('read', false);
        }
        if (count($filters) > 0) $filters['count'] = count($filters);

        return $query->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Inbox $inbox) => [
                'id' => $inbox->id,
                'box' => $inbox->box,
                'email' => $inbox->email,
                'subject' => $inbox->subject,
                'attachments' => count($inbox->attachments),
                'created_at' => $inbox->created_at->translatedFormat('j F Y H:i:s'),
                'read_at' => ($inbox->isRead()) ? $inbox->created_at->translatedFormat('j F Y H:i:s') : '',
                'read' => $inbox->isRead(),

                'url' => route('admin.mail.inbox.show', $inbox),
                'destroy' => route('admin.mail.inbox.destroy', $inbox),

            ]);

    }
}
