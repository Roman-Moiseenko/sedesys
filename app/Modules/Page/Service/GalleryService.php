<?php

namespace App\Modules\Page\Service;

use App\Modules\Base\Entity\Photo;
use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Page\Entity\Gallery;

class GalleryService
{

    public function create(Request $request): Gallery
    {
        $gallery = Gallery::register(
            $request->string('name')->trim()->value(),
            $request->string('slug')->trim()->value(),
        );

        $this->save_fields($gallery, $request);

        return  $gallery;
    }

    public function update(Gallery $gallery, Request $request)
    {
        $gallery->name = $request->string('name')->trim()->value();
        $slug = $request->string('slug')->trim()->value();
        $gallery->slug = empty($slug) ? Str::slug($gallery->name) : $slug;

        $gallery->save();

        $this->save_fields($gallery, $request);
    }

    private function save_fields(Gallery $gallery, Request $request)
    {
        $gallery->description = $request->string('description')->trim()->value();

        $gallery->save();
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
    }

    //TODO ***
    public function addPhoto(Gallery $gallery, Request $request)
    {
        if (empty($file = $request->file('file'))) throw new \DomainException('Нет файла');

        $sort = count($gallery->photos);
        $gallery->photos()->save(Photo::upload($file, '', $sort));
    }

    public function delPhoto(Gallery $gallery, Request $request)
    {
        $photo = Photo::find($request->integer('photo_id'));
        $photo->delete();
        foreach ($gallery->photos as $i => $photo) {
            $photo->update(['sort' => $i]);
        }
    }

    public function setAlt(Gallery $gallery, Request $request)
    {
        $id = $request->integer('photo_id');
        $alt = $request->string('alt')->trim()->value();
        foreach ($gallery->photos as $photo) {
            if ($photo->id === $id) {
                $photo->update(['alt' => $alt]);
            }
        }
    }

}
