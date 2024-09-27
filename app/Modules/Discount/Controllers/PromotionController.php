<?php

namespace App\Modules\Discount\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Discount\Entity\Promotion;
use App\Modules\Discount\Requests\PromotionRequest;
use App\Modules\Discount\Repository\PromotionRepository;
use App\Modules\Discount\Service\PromotionService;
use App\Modules\Page\Repository\TemplateRepository;
use App\Modules\Service\Repository\ServiceRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PromotionController extends Controller
{

    private PromotionService $service;
    private PromotionRepository $repository;
    private ServiceRepository $services;
    private TemplateRepository $templates;
    private string $tiny_api;

    public function __construct(
        PromotionService    $service,
        PromotionRepository $repository,
        ServiceRepository   $services,
        TemplateRepository  $templates,
    )
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->services = $services;
        $this->templates = $templates;
        $this->tiny_api = config('sedesys.tinymce');

    }

    public function index(Request $request)
    {
        $promotions = $this->repository->getIndex($request, $filters);
        $services = $this->services->forFilter();
        $statuses = $this->repository->getStatuses();

        return Inertia::render('Discount/Promotion/Index', [
                'promotions' => $promotions,
                'filters' => $filters,
                'services' => $services,
                'statuses' => $statuses,
            ]
        );
    }

    public function create(Request $request)
    {
        $templates = $this->templates->getTemplates('promotion');

        return Inertia::render('Discount/Promotion/Create', [
            'templates' => $templates,
            'tiny_api' => $this->tiny_api,
        ]);
    }

    public function store(PromotionRequest $request)
    {
        $request->validated();
        $promotion = $this->service->create($request);
        return redirect()
            ->route('admin.discount.promotion.show', $promotion)
            ->with('success', 'Новый promotion добавлен');
    }

    public function show(Promotion $promotion)
    {
        $services = $this->repository->outServices($promotion);
        $group_services = $this->repository->getGroupStatuses();

        $promotion = Promotion::where('id', $promotion->id)->with(['services'])->first();
        return Inertia::render('Discount/Promotion/Show', [
                'promotion' => $promotion,
                'services' => $services,
                'image' => $promotion->getImage(),
                'icon' => $promotion->getIcon(),
                'group_services' => $group_services,
            ]
        );
    }

    public function edit(Promotion $promotion)
    {
        $templates = $this->templates->getTemplates('promotion');

        return Inertia::render('Discount/Promotion/Edit', [
            'promotion' => $promotion,
            'image' => $promotion->getImage(),
            'icon' => $promotion->getIcon(),
            'templates' => $templates,
            'tiny_api' => $this->tiny_api,
        ]);
    }

    public function update(PromotionRequest $request, Promotion $promotion)
    {
        $request->validated();
        $this->service->update($promotion, $request);

        if ($request->boolean('close')) {
            return redirect()
                ->route('admin.discount.promotion.show', $promotion)
                ->with('success', 'Сохранение прошло успешно');
        } else {
            return redirect()->back()->with('success', 'Сохранение прошло успешно');
        }
    }

    public function destroy(Promotion $promotion)
    {
        $this->service->destroy($promotion);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }

    public function toggle(Promotion $promotion)
    {

        if ($promotion->isActive()) {
            $this->service->draft($promotion);
            $success = 'Акция отключена';
        } else {
            $this->service->activated($promotion);
            $success = 'Акция добавлена в очередь';
        }
        return redirect()->back()->with('success', $success);
    }

    public function start(Promotion $promotion)
    {
        $this->service->start($promotion);
        return redirect()->back()->with('success', 'Акция запущена');
    }

    public function finish(Promotion $promotion)
    {
        $this->service->finish($promotion);
        return redirect()->back()->with('success', 'Акция остановлена');
    }

    public function attach(Request $request, Promotion $promotion)
    {
        $this->service->attach($promotion, $request);
        return redirect()->back()->with('success', 'Услуга добавлена в акцию');
    }

    public function detach(Request $request, Promotion $promotion)
    {
        $this->service->detach($promotion, $request);
        return redirect()->back()->with('success', 'Услуга(и) убрана из акции');
    }

    public function set(Request $request, Promotion $promotion)
    {
        $this->service->set($promotion, $request);
        return redirect()->back()->with('success', 'Скидка на услугу изменена');
    }
}
