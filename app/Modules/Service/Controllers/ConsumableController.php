<?php

namespace App\Modules\Service\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Service\Entity\Consumable;
use App\Modules\Service\Requests\ConsumableRequest;
use App\Modules\Service\Repository\ConsumableRepository;
use App\Modules\Service\Service\ConsumableService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConsumableController extends Controller
{

    private ConsumableService $service;
    private ConsumableRepository $repository;

    public function __construct(ConsumableService $service, ConsumableRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }


    public function index(Request $request): \Inertia\Response
    {
        $consumables = $this->repository->getIndex($request, $filters);

        return Inertia::render('Service/Consumable/Index', [
                'consumables' => $consumables,
                'filters' => $filters,
            ]
        );
    }

    public function create(Request $request): \Inertia\Response
    {
        return Inertia::render('Service/Consumable/Create', [
            'route' => route('admin.service.consumable.store'),
        ]);
    }

    public function store(ConsumableRequest $request): RedirectResponse
    {
        $request->validated();
        $consumable = $this->service->create($request);
        return redirect()
            ->route('admin.service.consumable.show', $consumable)
            ->with('success', 'Новый consumable добавлен');
    }

    public function show(Consumable $consumable): \Inertia\Response
    {
        $out_services = $this->repository->outServices($consumable);

        return Inertia::render('Service/Consumable/Show', [
                'consumable' => $this->repository->ConsumableWithToArray($consumable),
                //'edit' => route('admin.service.consumable.edit', $consumable),
               // 'image' => $consumable->getImage(),
                'out_services' => $out_services,
            ]
        );
    }

    public function edit(Consumable $consumable): \Inertia\Response
    {
        return Inertia::render('Service/Consumable/Edit', [
            'consumable' => $this->repository->ConsumableToArray($consumable),
            'route' => route('admin.service.consumable.update', $consumable),
            'image' => $consumable->getImage(),
        ]);
    }

    public function update(ConsumableRequest $request, Consumable $consumable): RedirectResponse
    {
        $request->validated();
        $this->service->update($consumable, $request);

        if ($request->boolean('close')) {
            return redirect()
                ->route('admin.service.consumable.show', $consumable)
                ->with('success', 'Сохранение прошло успешно');
        } else {
            return redirect()->back()->with('success', 'Сохранение прошло успешно');
        }
    }

    public function destroy(Consumable $consumable): RedirectResponse
    {
        $this->service->destroy($consumable);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }

    public function toggle(Consumable $consumable): RedirectResponse
    {
        if ($consumable->isActive()) {
            $consumable->draft();
            $success = 'Расходный материал отправлен в черновик';
        } else {
            $consumable->activated();
            $success = 'Расходный материал доступен для услуг';
        }
        return redirect()->back()->with('success', $success);
    }

    public function attach(Request $request, Consumable $consumable)
    {
        $service = $this->service->attach_service($consumable, $request);
        return redirect()->back()->with('success', 'Услуга ' . $service->name . ' добавлена.');
    }

    public function detach(Request $request, Consumable $consumable)
    {
        $service = $this->service->detach_service($consumable, $request);
        return redirect()->back()->with('success', 'Услуга ' . $service->name . ' убрана.');
    }
}
