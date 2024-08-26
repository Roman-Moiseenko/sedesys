<?php

namespace App\Modules\Page\Service;

use App\Modules\Base\Entity\Meta;
use App\Modules\Base\Entity\Photo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Page\Entity\Page;
use Illuminate\Support\Str;

class PageService
{

    public function create(Request $request): Page
    {
        /**
         * Создаем объект с базовыми данными
         */
        $page = Page::register(
            $request->string('name')->trim()->value(),
            $request->string('slug')->trim()->value(),
        );

        $this->save_fields($page, $request);

        return $page;
    }

    public function update(Page $page, Request $request)
    {

        $page->name = $request->string('name')->trim()->value();
        $slug = $request->string('slug')->trim()->value();
        $page->slug = empty($slug) ? Str::slug($page->name) : $slug;
        $page->save();

        $this->save_fields($page, $request);
    }

    private function save_fields(Page $page, Request $request)
    {
        $page->meta = Meta::fromRequest($request);

        $page->template = $request->string('template')->value();
        $page->parent_id = $request->integer('parent_id', null);

        $page->text = $request->string('text')->value();
        $page->save();

        if ($request->boolean('clear_image') && !is_null($page->image)) {
            $page->image->delete();
        }
        if ($request->boolean('clear_icon') && !is_null($page->icon)) {
            $page->icon->delete();
        }
        $this->image($page, $request->file('image'));
        $this->icon($page, $request->file('icon'));

    }


    public function destroy(Page $page)
    {
        /**
         * Проверить на возможность удаления
         */
        $page->delete();
    }

    private function image(Page $page, $file): void
    {
        if (empty($file)) return;
        $page->image->newUploadFile($file, 'image');
        $page->refresh();
    }

    private function icon(Page $page, $file): void
    {
        if (empty($file)) return;
        $page->icon->newUploadFile($file, 'icon');
        $page->refresh();
    }
}
