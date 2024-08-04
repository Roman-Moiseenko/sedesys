<?php

namespace App\Modules\Page\Service;

use App\Modules\Page\Entity\Page;
use App\Modules\Page\Entity\Widget;
use App\Modules\Page\Repository\TemplateRepository;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;

class TemplateService
{

    private TemplateRepository $repository;

    public function __construct(TemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(Request $request): array
    {
        $type = $request->string('type')->value();
        $template = $request->string('template')->trim()->value();
        $name = $request->string('name')->trim()->value();
        $file = $this->repository->getPath($type) . $template . '.blade.php';
        //Заменяем данные в шаблоне
        //Возможно расширение параметров, для версии 0.2 dummyParamsName = Имя шаблона
        $content = str_replace([
            'dummyParamsName',
        ], [
            $name,
        ],
            file_get_contents(resource_path('views/web/templates/base/'. $type . '.stub'))
        );

        file_put_contents($file, $content);

        return ['type' => $type, 'template' => $template];
    }


    public function destroy(string $type, string $template)
    {
        $file = $this->repository->getPath($type) . $template . '.blade.php';

        $isset = null;
        if ($type == 'widget') {
            $isset = Widget::where('template', $template)->first();
        }
        if ($type == 'page') {
            $isset = Page::where('template', $template)->first();
        }

        if (is_null($isset)) {
            unlink($file);
        } else {
            throw new \DomainException('Шаблон используется. Удалить нельзя');
        }

    }

    public function update(Request $request)
    {
        $content = $request->string('content')->value();
        $type = $request->string('type')->value();
        $template = $request->string('template')->value();
        $file = $this->repository->getPath($type) . $template . '.blade.php';

        file_put_contents($file, $content);
    }
}
