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
        $page->setSlug($request->string('slug')->trim()->value());
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

        $page->saveImage(
            $request->file('image'),
            $request->boolean('clear_image')
        );
        $page->saveIcon(
            $request->file('icon'),
            $request->boolean('clear_icon')
        );
    }

    public function destroy(Page $page)
    {
        /**
         * Проверить на возможность удаления
         */
        $page->delete();
    }
}
