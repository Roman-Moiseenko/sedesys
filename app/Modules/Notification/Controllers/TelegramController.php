<?php
declare(strict_types=1);

namespace App\Modules\Notification\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Notification\Service\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{

    private TelegramService $service;

    public function __construct(TelegramService $service)
    {
        $this->service = $service;
    }

    public function chat_id()
    {
        $list = $this->service->getListChatIds();
        return response()->json($list);
    }

    public function web_hook(Request $request)
    {
        Log::info(json_encode($request->all()));
        $this->service->checkOperation(json_encode($request->all()));

        return response('true', 200);
        //TODO Принимаев вебхуки
    }
}
