<?php

namespace App\Modules\Service\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Repository\EmployeeRepository;
use App\Modules\Service\Entity\Review;
use App\Modules\Service\Repository\ServiceRepository;
use App\Modules\Service\Requests\ReviewRequest;
use App\Modules\Service\Repository\ReviewRepository;
use App\Modules\Service\Service\ReviewService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewController extends Controller
{

    private ReviewService $service;
    private ReviewRepository $repository;
    private ServiceRepository $serviceRepository;
    private EmployeeRepository $employeeRepository;

    public function __construct(
        ReviewService      $service,
        ReviewRepository   $repository,
        ServiceRepository  $serviceRepository,
        EmployeeRepository $employeeRepository
    )
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->serviceRepository = $serviceRepository;
        $this->employeeRepository = $employeeRepository;
    }

    public function index(Request $request)
    {
        $reviews = $this->repository->getIndex($request, $filters);
        $services = $this->serviceRepository->forFilter();
        $employees = $this->employeeRepository->forFilter();

        return Inertia::render('Service/Review/Index', [
                'reviews' => $reviews,
                'filters' => $filters,
                'services' => $services,
                'employees' => $employees,
            ]
        );
    }

    public function create(Request $request)
    {
        $externals = $this->repository->getExternals();
        $services = $this->serviceRepository->getActive();
        $employees = $this->employeeRepository->getActive();

        return Inertia::render('Service/Review/Create', [
            'externals' => $externals,
            'services' => $services,
            'employees' => $employees,
        ]);
    }

    public function store(ReviewRequest $request)
    {
        $request->validated();
        $review = $this->service->create($request);
        return redirect()
            ->route('admin.service.review.index')
            ->with('success', 'Новый отзыв добавлен');
    }

    public function show(Review $review)
    {
        $review = Review::where('id', $review->id)->with(['user', 'service', 'employee'])->first();

        return Inertia::render('Service/Review/Show', [
                'review' => $review,
                'gallery' => $this->repository->getPhotos($review),
            ]
        );
    }

    public function edit(Review $review)
    {
        $externals = $this->repository->getExternals();
        $services = $this->serviceRepository->getActive();
        $employees = $this->employeeRepository->getActive();

        return Inertia::render('Service/Review/Edit', [
            'review' => $review,
            'externals' => $externals,
            'services' => $services,
            'employees' => $employees,
        ]);
    }

    public function update(ReviewRequest $request, Review $review)
    {
        $request->validated();
        $this->service->update($review, $request);
        if ($request->boolean('close')) {
            return redirect()
                ->route('admin.service.review.show', $review)
                ->with('success', 'Сохранение прошло успешно');
        } else {
            return redirect()->back()->with('success', 'Сохранение прошло успешно');
        }
    }

    public function destroy(Review $review)
    {
        $this->service->destroy($review);
        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }

    public function toggle(Review $review)
    {
        if ($review->isActive()) {
            $review->draft();
            $success = 'Отзыв убран из показа на сайте';
        } else {
            $review->activated();
            $success = 'Отзыв добавлен на сайт';
        }
        return redirect()->back()->with('success', $success);
    }
}
