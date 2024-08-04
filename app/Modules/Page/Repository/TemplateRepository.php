<?php

namespace App\Modules\Page\Repository;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Page\Entity\Template;

class TemplateRepository
{

    public function getIndex(Request $request): array
    {
        return array_merge(
            $this->getDataArray('page'),
            $this->getDataArray('widget'),
        );
    }


    private function getDataArray(string $type): array
    {
        $path = $this->getPath($type);

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
                'type' => $type,
                'url' => route('admin.page.template.show', ['type' => $type, 'template' => $template[1]]),
                'destroy' => route('admin.page.template.destroy', ['type' => $type, 'template' => $template[1]]),
            ];
        }
        return $result;
    }

    public function getPath(string $type): string
    {
        return resource_path() . '/views/web/templates/' . $type . '/';
    }
}
