<?php

namespace App\Modules\Page\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Base\Entity\Photo;
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
        ]);
    }

    public function store(GalleryRequest $request)
    {
        $request->validated();
        $gallery = $this->service->create($request);
        return redirect()
            ->route('admin.page.gallery.show', $gallery)
            ->with('success', 'Новая галерея добавлена');
    }

    public function show(Gallery $gallery)
    {
        return Inertia::render('Page/Gallery/Show', [
                'gallery' => $gallery,
                'photos' => $this->repository->getPhotos($gallery),
            ]
        );
    }

    public function edit(Gallery $gallery)
    {
        return Inertia::render('Page/Gallery/Edit', [
            'gallery' => $gallery,
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
        return redirect()->route('admin.page.gallery.show', $gallery)->with('success', 'Сохранено');
    }

    public function del(Request $request, Gallery $gallery)
    {
        $this->service->delPhoto($gallery, $request);
        return redirect()->back()->with('success', 'Сохранено');
    }

    public function set(Request $request, Gallery $gallery)
    {
        $this->service->setAlt($gallery, $request);
        return redirect()->back()->with('success', 'Сохранено');
    }

    //AJAX

    public function get_tree()
    {
        $tree = $this->repository->getTree();
        return response()->json($tree);
    }

    public function get_photo(Request $request)
    {
        /** @var Photo $photo */

        $photo = Photo::find($request->integer('photo_id'));
        if (!is_null($photo)) return response()->json($photo->getThumbUrl('original'));
        return response()->json(false);
    }

}
