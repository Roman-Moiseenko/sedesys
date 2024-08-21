<?php

namespace App\Modules\Page\Service;

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

        if ($request->boolean('clear_file') && !is_null($page->photo)) {
            $page->photo->delete();
        }

        $this->save_fields($page, $request);
    }

    private function save_fields(Page $page, Request $request)
    {
        /**
         * Сохраняем оставшиеся поля
         */
        $page->title = $request->string('title')->trim()->value();
        $page->description = $request->string('description')->trim()->value();
        $page->template = $request->string('template')->value();
        $page->parent_id = $request->input('parent_id', null);

        $page->text = $request->string('text')->value();
        $page->save();

        $this->photo($page, $request->file('file'));
    }


    public function destroy(Page $page)
    {
        /**
         * Проверить на возможность удаления
         */
        $page->delete();
    }

    private function photo(Page $page, $file): void
    {
        if (empty($file)) return;
        if (!empty($page->photo)) {
            $page->photo->newUploadFile($file);
        } else {
            $page->photo()->save(Photo::upload($file));
        }
        $page->refresh();
    }
}
