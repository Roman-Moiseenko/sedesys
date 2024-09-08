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

        $page = Page::register(
            $request->string('displayed.name')->trim()->value(),
            $request->string('displayed.slug')->trim()->value(),
        );

        $this->save_fields($page, $request);

        return $page;
    }

    public function update(Page $page, Request $request)
    {
        $this->save_fields($page, $request);
    }

    private function save_fields(Page $page, Request $request)
    {
        $page->saveDisplayed($request);

        $page->parent_id = $request->integer('parent_id', null);
        $page->save();
    }

    public function destroy(Page $page)
    {
        $page->delete();
    }
}
