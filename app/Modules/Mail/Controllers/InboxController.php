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
            ]
        );
    }

    public function create(Request $request)
    {
        return Inertia::render('Mail/Inbox/Create', [
            'route' => route('admin.mail.inbox.store'),
        ]);
    }

    public function store(InboxRequest $request)
    {
        $request->validated();
        $inbox = $this->service->create($request);
        return redirect()
            ->route('admin.mail.inbox.show', $inbox)
            ->with('success', 'Новый inbox добавлен');
    }

    public function show(Inbox $inbox)
    {
        return Inertia::render('Mail/Inbox/Show', [
                'inbox' => $inbox,
                'edit' => route('admin.mail.inbox.edit', $inbox),
            ]
        );
    }

    public function edit(Inbox $inbox)
    {
        return Inertia::render('Mail/Inbox/Edit', [
            'inbox' => $inbox,
            'route' => route('admin.mail.inbox.update', $inbox),
        ]);
    }

    public function update(InboxRequest $request, Inbox $inbox)
    {
        $request->validated();
        $this->service->update($inbox, $request);
        return redirect()
            ->route('admin.mail.inbox.show', $inbox)
            ->with('success', 'Сохранение прошло успешно');
    }

    public function destroy(Inbox $inbox)
    {
        $this->service->destroy($inbox);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }
}
