<?php

namespace App\Modules\Mail\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Mail\Entity\SystemMail;
use App\Modules\Mail\Requests\SystemMailRequest;
use App\Modules\Mail\Repository\SystemMailRepository;
use App\Modules\Mail\Service\SystemMailService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SystemMailController extends Controller
{

    private SystemMailService $service;
    private SystemMailRepository $repository;

    public function __construct(SystemMailService $service, SystemMailRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }


    public function index(Request $request)
    {
        $systemMails = $this->repository->getIndex($request);

        return Inertia::render('Mail/SystemMail/Index', [
                'systemMails' => $systemMails,
            ]
        );
    }

    public function create(Request $request)
    {
        return Inertia::render('Mail/SystemMail/Create', [
            'route' => route('admin.mail.systemMail.store'),
        ]);
    }

    public function store(SystemMailRequest $request)
    {
        $request->validated();
        $systemMail = $this->service->create($request);
        return redirect()
            ->route('admin.mail.systemMail.show', $systemMail)
            ->with('success', 'Новый systemMail добавлен');
    }

    public function show(SystemMail $systemMail)
    {
        return Inertia::render('Mail/SystemMail/Show', [
                'systemMail' => $systemMail,
                'edit' => route('admin.mail.systemMail.edit', $systemMail),
            ]
        );
    }

    public function edit(SystemMail $systemMail)
    {
        return Inertia::render('Mail/SystemMail/Edit', [
            'systemMail' => $systemMail,
            'route' => route('admin.mail.systemMail.update', $systemMail),
        ]);
    }

    public function update(SystemMailRequest $request, SystemMail $systemMail)
    {
        $request->validated();
        $this->service->update($systemMail, $request);
        return redirect()
            ->route('admin.mail.systemMail.show', $systemMail)
            ->with('success', 'Сохранение прошло успешно');
    }

    public function destroy(SystemMail $systemMail)
    {
        $this->service->destroy($systemMail);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }
}
