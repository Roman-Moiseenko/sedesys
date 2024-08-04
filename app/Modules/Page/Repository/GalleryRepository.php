<?php

namespace App\Modules\Page\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Page\Entity\Gallery;

class GalleryRepository
{

    public function getIndex(Request $request): Arrayable
    {
        return Gallery::orderBy('name')
            ->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Gallery $gallery) => [
                'id' => $gallery->id,
                'name' => $gallery->name,
                'slug' => $gallery->slug,
                'description' => $gallery->description,
                'count' => $gallery->photos()->count(),
                'url' => route('admin.page.gallery.show', $gallery),
                'edit' => route('admin.page.gallery.edit', $gallery),
                'destroy' => route('admin.page.gallery.destroy', $gallery),
            ]);
    }

    public function getPhotos(Gallery $gallery): array
    {
        $result = [];
        foreach ($gallery->photos as $photo) {
            $result[] = [
                'id' => $photo->id,
                'name' => $photo->file,
                'url' => $photo->getThumbUrl('original'),
                'alt' => $photo->alt,
                'title' => $photo->title,
                'description' => $photo->description,
            ];
        }
        return $result;
    }
}
