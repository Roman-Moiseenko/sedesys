<?php

namespace App\Modules\Mail\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Mail\Entity\SystemMail;

class SystemMailRepository
{

    public function getIndex(Request $request): Arrayable
    {
        $systemMails = SystemMail::orderBy('name')
            ->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(SystemMail $systemMail) => [
                'id' => $systemMail->id,
                'name' => $systemMail->name,
                /**

                 */

                'url' => route('admin.mail.systemMail.show', $systemMail),
                'edit' => route('admin.mail.systemMail.edit', $systemMail),
                'destroy' => route('admin.mail.systemMail.destroy', $systemMail),

            ]);

        return $systemMails;
    }
}
