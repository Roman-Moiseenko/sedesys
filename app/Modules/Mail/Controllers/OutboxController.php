<?php

namespace App\Modules\Mail\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Mail\Entity\Outbox;
use App\Modules\Mail\Requests\OutboxRequest;
use App\Modules\Mail\Repository\OutboxRepository;
use App\Modules\Mail\Service\OutboxService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OutboxController extends Controller
{

    private OutboxService $service;
    private OutboxRepository $repository;

    public function __construct(OutboxService $service, OutboxRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }


    public function index(Request $request)
    {
        $outboxes = $this->repository->getIndex($request);

        return Inertia::render('Mail/Outbox/Index', [
                'outboxes' => $outboxes,
            ]
        );
    }

    public function create(Request $request)
    {
        return Inertia::render('Mail/Outbox/Create', [
            'route' => route('admin.mail.outbox.store'),
        ]);
    }

    public function store(OutboxRequest $request)
    {
        $request->validated();
        $outbox = $this->service->create($request);
        return redirect()
            ->route('admin.mail.outbox.show', $outbox)
            ->with('success', 'Новый outbox добавлен');
    }

    public function show(Outbox $outbox)
    {
        return Inertia::render('Mail/Outbox/Show', [
                'outbox' => $outbox,
                'edit' => route('admin.mail.outbox.edit', $outbox),
            ]
        );
    }

    public function edit(Outbox $outbox)
    {
        return Inertia::render('Mail/Outbox/Edit', [
            'outbox' => $outbox,
            'route' => route('admin.mail.outbox.update', $outbox),
        ]);
    }

    public function update(OutboxRequest $request, Outbox $outbox)
    {
        $request->validated();
        $this->service->update($outbox, $request);
        return redirect()
            ->route('admin.mail.outbox.show', $outbox)
            ->with('success', 'Сохранение прошло успешно');
    }

    public function destroy(Outbox $outbox)
    {
        $this->service->destroy($outbox);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }
}
