<?php

namespace App\Modules\Mail\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Mail\Entity\Inbox;
use App\Modules\Mail\Requests\InboxRequest;
use App\Modules\Mail\Repository\InboxRepository;
use App\Modules\Mail\Service\InboxService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InboxController extends Controller
{

    private InboxService $service;
    private InboxRepository $repository;

    public function __construct(InboxService $service, InboxRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }


    public function index(Request $request)
    {
        $inboxes = $this->repository->getIndex($request, $filters);

        return Inertia::render('Mail/Inbox/Index', [
                'inboxes' => $inboxes,
                'filters' => $filters,
                'load' => route('admin.mail.inbox.load'),
                'boxes' => $this->repository->getBoxes(),
            ]
        );
    }


    public function show(Inbox $inbox)
    {
        if (!$inbox->isRead()) $inbox->read();
        return Inertia::render('Mail/Inbox/Show', [
                'inbox' => $inbox,
                'delete' => route('admin.mail.inbox.destroy', $inbox),
                'attachment' => route('admin.mail.inbox.attachment'),
            ]
        );
    }


    public function load()
    {
        $count = $this->service->readAllInBox();
        return redirect()->back()
            ->with('success', 'Почтовые ящики обновлены! Получено ' . $count . ' писем.');
    }

    public function destroy(Inbox $inbox)
    {
        $this->service->destroy($inbox);
        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }
}
