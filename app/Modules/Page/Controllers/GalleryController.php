<?php

namespace App\Modules\Page\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Page\Entity\Gallery;
use App\Modules\Page\Requests\GalleryRequest;
use App\Modules\Page\Repository\GalleryRepository;
use App\Modules\Page\Service\GalleryService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GalleryController extends Controller
{

    private GalleryService $service;
    private GalleryRepository $repository;

    public function __construct(GalleryService $service, GalleryRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }


    public function index(Request $request)
    {
        $galleries = $this->repository->getIndex($request);

        return Inertia::render('Page/Gallery/Index', [
                'galleries' => $galleries,
            ]
        );
    }

    public function create(Request $request)
    {
        return Inertia::render('Page/Gallery/Create', [
            'route' => route('admin.page.gallery.store'),
        ]);
    }

    public function store(GalleryRequest $request)
    {
        $request->validated();
        $gallery = $this->service->create($request);
        return redirect()
            ->route('admin.page.gallery.show', $gallery)
            ->with('success', 'Новый gallery добавлен');
    }

    public function show(Gallery $gallery)
    {
        return Inertia::render('Page/Gallery/Show', [
                'gallery' => $gallery,
                'edit' => route('admin.page.gallery.edit', $gallery),
                'add' => route('admin.page.gallery.add', $gallery),
                'del' => route('admin.page.gallery.del', $gallery),
                'set' => route('admin.page.gallery.set', $gallery),
                'photos' => $this->repository->getPhotos($gallery),
            ]
        );
    }

    public function edit(Gallery $gallery)
    {
        return Inertia::render('Page/Gallery/Edit', [
            'gallery' => $gallery,
            'route' => route('admin.page.gallery.update', $gallery),
        ]);
    }

    public function update(GalleryRequest $request, Gallery $gallery)
    {
        $request->validated();
        $this->service->update($gallery, $request);
        return redirect()
            ->route('admin.page.gallery.show', $gallery)
            ->with('success', 'Сохранение прошло успешно');
    }

    public function destroy(Gallery $gallery)
    {
        $this->service->destroy($gallery);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }

    public function add(Request $request, Gallery $gallery)
    {
        $this->service->addPhoto($gallery, $request);
        return redirect()->route('admin.page.gallery.show', $gallery);
    }

    public function del(Request $request, Gallery $gallery)
    {
        $this->service->delPhoto($gallery, $request);
        return redirect()->back();
    }

    public function set(Request $request, Gallery $gallery)
    {
        $this->service->setAlt($gallery, $request);
        return redirect()->back();
    }
}
