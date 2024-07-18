<?php

namespace App\Modules\Employee\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Employee\Entity\Message;

class MessageService
{
    //TODO Внести методы и объект
    public function create(Request $request): Message
    {
        $message = Message::register();


        return  $message;
    }

    public function update(Message $message, Request $request)
    {
        return $message;
    }

    public function delete(Message $message)
    {
        $message->delete();
    }
}
