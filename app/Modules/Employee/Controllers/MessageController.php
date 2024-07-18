<?php

namespace App\Modules\Employee\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Entity\Message;
use App\Modules\Employee\Requests\MessageRequest;
use App\Modules\Employee\Resources\MessageResource;
use App\Modules\Employee\Service\MessageService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Inertia\Inertia;

class MessageController extends Controller
{

    private MessageService $service;

    public function __construct(MessageService $service)
    {
        $this->service = $service;
    }


    public function index(Request $request)
    {
        /*
        [$column, $order] = explode(',', $request->input('sortBy', 'id,asc'));
        $pageSize = (int) $request->input('pageSize', 10);

        $resource = Message::query()
            ->when($request->filled('search'), function (Builder $q) use ($request) {
                $q->where(Message::COLUMN_NAME, 'like', '%'.$request->search.'%');
            })
            ->orderBy($column, $order)->paginate($pageSize);
        */

        return Inertia::render('Employee/Message/Index', [

            ]
        );
    }

    public function create(Request $request)
    {

        return Inertia::render('Employee/Message/Create', []);
    }



    public function store(MessageRequest $request)
    {
        $data = $request->validated();
        $message = $this->service->create($request->all()->except('_token'));
        return redirect()->route('admin.employee.message.show', $message);
    }

    public function show(Message $message)
    {

        return Inertia::render('Employee/Message/Show', [
                'message' => $message
            ]
        );
    }

    public function edit(Message $message)
    {

        return Inertia::render('Employee/Message/Edit', [
            'message' => $message
        ]);
    }

    public function update(MessageRequest $request, Message $message)
    {
        $data = $request->validated();
        $message = $this->service->update($message, $request);
        return redirect()->route('admin.employee.message.show', $message);
    }

    public function destroy(Message $message)
    {
        $this->service->delete($message);

        return redirect()->back();
    }
}
