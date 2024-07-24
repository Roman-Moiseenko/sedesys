<?php

namespace App\Modules\Page\Service;

use App\Modules\Base\Entity\Photo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Page\Entity\Page;

class PageService
{

    public function create(Request $request): Page
    {
        /**
         * Создаем объект с базовыми данными
         */
        $page = Page::register(
            (string)$request->string('name'),
            (string)$request->string('slug')
        );

        $this->save_fields($page, $request);

        return $page;
    }

    public function update(Page $page, Request $request)
    {
        /**
         * Сохраняем базовые поля
         */
        $page->name = (string)$request->string('name');
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
        $page->title = (string)$request->string('title');
        $page->description = (string)$request->string('description');
        $page->template = (string)$request->string('template');
        $page->parent_id = $request->input('parent_id', null);

        $page->text = (string)$request->string('text');
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

    public function photo(Page $page, $file): void
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
