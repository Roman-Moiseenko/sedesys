<?php

namespace App\Modules\Mail\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Mail\Entity\SystemMail;

class SystemMailRepository
{

    public function getIndex(Request $request): Arrayable
    {
        $systemMails = SystemMail::orderByDesc('created_at')
            ->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(SystemMail $system) => [
                'id' => $system->id,
                'mailable' => $system->getMailable(),
                'created_at' => $system->created_at->translatedFormat('j F Y H:i:s'),
                'updated_at' => $system->updated_at->translatedFormat('j F Y H:i:s'),
                'user' => $system->user->getPublicName(),
                'title' => $system->title,
                'content' => $system->content,
                'attachments' => $system->attachments,
                'count' => $system->count,
                'url' => route('admin.mail.system.show', $system),
                'repeat' => route('admin.mail.system.repeat', $system),

            ]);

        return $systemMails;
    }
}
