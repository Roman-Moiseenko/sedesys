<?php
declare(strict_types=1);

namespace App\Console\Commands\Development;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Output\ConsoleOutput;
use function app_path;
use function base_path;

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
        $this->createRepository();
        $this->createService();
        $this->createMenus();
        $this->createBreadCrumbs();
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

    private function createService(): void
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
    private function createController(): void
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
        $path = $this->module_path.'/routes_admin.php';

        if ($this->alreadyExists($path)) {
            $this->error('Routes already exists! Add it manually!');
        } else {
            $stub = $this->files->get(base_path('stubs/backEnd/routes.admin.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('Routes created successfully.');
        }
    }

    private function createMenus(): void
    {
        $path = $this->module_path.'/menus.php';

        if ($this->alreadyExists($path)) {
            $this->error('Menus already exists! Add it manually!');
        } else {
            $stub = $this->files->get(base_path('stubs/backEnd/menus.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('Menus created successfully.');
        }
    }

    private function createBreadCrumbs() {
        $path = $this->module_path.'/breadcrumbs.php';

        if ($this->alreadyExists($path)) {
            $this->error('BreadCrumbs already exists! Add it manually!');
        } else {
            $stub = $this->files->get(base_path('stubs/backEnd/breadcrumbs.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('BreadCrumbs created successfully.');
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
    private function createRepository()
    {
        $path = $this->module_path."/Repository/{$this->entity}Repository.php";

        if ($this->alreadyExists($path)) {
            $this->error('Repository already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/backEnd/repository.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('Repository created successfully.');
        }
    }
}
