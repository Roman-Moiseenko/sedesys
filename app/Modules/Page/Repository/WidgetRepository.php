<?php

namespace App\Modules\Page\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Page\Entity\Widget;

class WidgetRepository
{

    public function getIndex(Request $request): Arrayable
    {
        $widgets = Widget::orderBy('name')
            ->paginate(20)->withQueryString()
            ->through(fn(Widget $widget) => [
                'id' => $widget->id,
                'name' => $widget->name,
                /**

                 */

                'url' => route('admin.page.widget.show', $widget),
                'edit' => route('admin.page.widget.edit', $widget),
                'destroy' => route('admin.page.widget.destroy', $widget),

            ]);

        return $widgets;
    }
}
