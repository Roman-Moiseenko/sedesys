<?php

namespace App\Modules\Page\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Page\Entity\Template;

class TemplateRepository
{

    public function getIndex(Request $request, &$filters)
    {
        $result = [];

        if ($request->has('type')) {
            $type = $request->string('type')->value();
            $result = $this->getDataArray($type);
            $filters['type'] = $type;
            $filters['count'] = 1;
        } else {
            $filters = [];
            foreach (Template::TEMPLATES as $key => $value) {
                $result = array_merge($result, $this->getDataArray($key));
            }
        }
        return collect($result);
    }


    public function getDataArray(string $type): array
    {
        $path = Template::Path($type);

        $files = glob($path . '*.blade.php');

        $result = [];
        foreach ($files as $file) {
            preg_match('/^.+\/(.+)\.blade\.php$/', $file, $template);
            preg_match('/<!--template:(.+)-->/', file_get_contents($file), $name);

            /**
             * Другие данные, на будущее
             */
            $result[] = [
                'file' => $file,
                'template' => $template[1],
                'name' => empty($name) ? $template[1] : $name[1],
                'type' => Template::TEMPLATES[$type],
                'url' => route('admin.page.template.show', ['type' => $type, 'template' => $template[1]]),
                'destroy' => route('admin.page.template.destroy', ['type' => $type, 'template' => $template[1]]),
            ];
        }
        return $result;
    }

}
