<?php

namespace App\Modules\Page\Service;

use App\Modules\Page\Repository\TemplateRepository;
use Illuminate\Http\Request;

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
        //TODO Сделать шаблоны по типам и загружать как базовые данные в файл

        $template = $request->string('template')->trim()->value();
        $name = $request->string('name')->trim()->value();

        $file = $this->repository->getPath($type) . $template . '.blade.php';

        file_put_contents($file, '<!--template:'. $name .'.-->');

        return ['type' => $type, 'template' => $template];
    }


    public function destroy(string $type, string $template)
    {
        $file = $this->repository->getPath($type) . $template . '.blade.php';
        unlink($file);
    }
}
