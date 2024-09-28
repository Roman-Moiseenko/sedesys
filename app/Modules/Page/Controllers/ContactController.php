<?php

namespace App\Modules\Page\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Page\Entity\Contact;
use App\Modules\Page\Requests\ContactRequest;
use App\Modules\Page\Repository\ContactRepository;
use App\Modules\Page\Service\ContactService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{

    private ContactService $service;
    private ContactRepository $repository;

    public function __construct(ContactService $service, ContactRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $contacts = $this->repository->getIndex($request);
        return Inertia::render('Page/Contact/Index', [
                'contacts' => $contacts,
            ]
        );
    }

    public function create(Request $request)
    {
        return Inertia::render('Page/Contact/Create', [
        ]);
    }

    public function store(ContactRequest $request)
    {
        $request->validated();
        $contact = $this->service->create($request);
        return redirect()
            ->route('admin.page.contact.show', $contact)
            ->with('success', 'Новый contact добавлен');
    }

    public function show(Contact $contact)
    {
        return Inertia::render('Page/Contact/Show', [
                'contact' => $contact,
            ]
        );
    }

    public function edit(Contact $contact)
    {
        return Inertia::render('Page/Contact/Edit', [
            'contact' => $contact,
        ]);
    }

    public function update(ContactRequest $request, Contact $contact)
    {
        $request->validated();
        $this->service->update($contact, $request);
        return redirect()
            ->route('admin.page.contact.show', $contact)
            ->with('success', 'Сохранение прошло успешно');
    }

    public function destroy(Contact $contact)
    {
        $this->service->destroy($contact);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }

    public function toggle(Contact $contact)
    {
        if ($this->service->toggle($contact)) {
            $success = 'Контакт добавлен в меню сайта';
        } else {
            $success = 'Контакт убран из показа';
        }
        return redirect()->back()->with('success', $success);
    }

    public function up(Contact $contact)
    {
        $this->service->up($contact);
        return redirect()->back()->with('success', 'Сохранено');
    }
    public function down(Contact $contact)
    {
        $this->service->down($contact);
        return redirect()->back()->with('success', 'Сохранено');
    }
}
