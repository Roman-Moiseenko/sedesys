<?php

namespace App\Modules\Feedback\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Feedback\Entity\Template;

class TemplateService
{

    public function create(Request $request): Template
    {
        $template = Template::register(
            $request->string('name')->trim()->value(),
        );

        $this->save_fields($template, $request);

        return  $template;
    }

    public function update(Template $template, Request $request)
    {
        $template->name = $request->string('name')->trim()->value();
        $template->save();

        $this->save_fields($template, $request);
    }

    private function save_fields(Template $template, Request $request)
    {
        $template->color = $request->string('color');
        $template->template = $request->string('template');

        $template->save();
    }


    public function destroy(Template $template)
    {
        /**
         * Проверить на возможность удаления
         */
        $template->delete();
    }
}
