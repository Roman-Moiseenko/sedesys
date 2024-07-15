<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Output\ConsoleOutput;

class MakeBackEndModule extends MakeModuleCommand
{
    public function __construct()
    {
        parent::__construct();
        $this->output = new ConsoleOutput();
    }

    private string $module_path;

    /**
     * @throws FileNotFoundException
     */
    protected function create($module, $entity) {
        $this->files = new Filesystem();
        $this->module = $module;
        $this->entity = $entity;
        $this->module_path = app_path('Modules/'.$this->module);

        $this->createModel();
        $this->createController();
        $this->createRoutes();
        $this->createRequest();
        $this->createResource();
        $this->createService();
    }

    protected function createModel()
    {
        $path = $this->module_path."/Entity/{$this->entity}.php";

        if ($this->alreadyExists($path)) {
            $this->error('Model already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/backEnd/model.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('Model created successfully.');
        }
    }

    private function createService()
    {
        $path = $this->module_path."/Service/{$this->entity}Service.php";

        if ($this->alreadyExists($path)) {
            $this->error('Service already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/backEnd/service.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('Service created successfully.');
        }
    }

    /**
     * @throws FileNotFoundException
     */
    private function createController()
    {
        $path = $this->module_path."/Controllers/{$this->entity}Controller.php";

        if ($this->alreadyExists($path)) {
            $this->error('Controller already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/backEnd/controller.api.stub'));

            $this->createFileWithStub($stub, $path);

            $this->info('Controller created successfully.');
        }
    }

    /**
     * @throws FileNotFoundException
     */
    private function createRoutes() {
        $path = $this->module_path.'/routes_api.php';

        if ($this->alreadyExists($path)) {
            //TODO Продумать добавление в файл

            $this->error('Routes already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/backEnd/routes.api.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('Routes created successfully.');
        }
    }

    /**
     * @throws FileNotFoundException
     */
    private function createRequest()
    {
        $path = $this->module_path."/Requests/{$this->entity}Request.php";

        if ($this->alreadyExists($path)) {
            $this->error('Request already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/backEnd/request.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('Request created successfully.');
        }
    }

    /**
     * @throws FileNotFoundException
     */
    private function createResource()
    {
        $path = $this->module_path."/Resources/{$this->entity}Resource.php";

        if ($this->alreadyExists($path)) {
            $this->error('Resource already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/backEnd/resource.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('Resource created successfully.');
        }
    }
}
