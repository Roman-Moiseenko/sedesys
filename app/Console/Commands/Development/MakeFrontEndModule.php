<?php
declare(strict_types=1);

namespace App\Console\Commands\Development;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Output\ConsoleOutput;
use function base_path;

class MakeFrontEndModule extends MakeModuleCommand
{

    public function __construct()
    {
        parent::__construct();
        $this->output = new ConsoleOutput();
    }

    private string $module_path;

    /**
     * @param $module
     * @throws FileNotFoundException
     */
    protected function create($module, $entity) {
        $this->files = new Filesystem();
        $this->module = $module;
        $this->entity = $entity;
        $this->module_path = base_path('resources/js/modules/'.lcfirst((string)$this->module));

      /*  $this->createVueList();
        $this->createVueView();
        $this->createVueForm();*/

        $this->createVueIndex();
        $this->createVueCreate();
        $this->createVueEdit();
        $this->createVueShow();

/*
        $this->createStore();
        $this->createStoreTypes();
        $this->createStoreActions();

        $this->createRoutes();
        $this->createApi();
        */
    }

    private function createVueIndex()
    {
        $path = base_path('resources/js/Pages/') . (string)$this->module . '/' . (string)$this->entity . '/Index.vue';


        if ($this->alreadyExists($path)) {
            $this->error('Index Component already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/frontEnd/vue.index.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('Index Component created successfully.');
        }
    }

    private function createVueCreate()
    {
        $path = base_path('resources/js/Pages/') . (string)$this->module . '/' . (string)$this->entity . '/Create.vue';


        if ($this->alreadyExists($path)) {
            $this->error('Create Component already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/frontEnd/vue.create.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('Create Component created successfully.');
        }
    }

    private function createVueEdit()
    {
        $path = base_path('resources/js/Pages/') . (string)$this->module . '/' . (string)$this->entity . '/Edit.vue';


        if ($this->alreadyExists($path)) {
            $this->error('Edit Component already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/frontEnd/vue.edit.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('Edit Component created successfully.');
        }
    }

    private function createVueShow()
    {
        $path = base_path('resources/js/Pages/') . (string)$this->module . '/' . (string)$this->entity . '/Show.vue';


        if ($this->alreadyExists($path)) {
            $this->error('Show Component already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/frontEnd/vue.show.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('Show Component created successfully.');
        }
    }


    /**
     * Create a Vue component file for the module.
     *
     * @return void
     * @throws FileNotFoundException
     */
    private function createVueList()
    {
        $path = $this->module_path."/components/{$this->module}List.vue";

        if ($this->alreadyExists($path)) {
            $this->error('VueList Component already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/frontEnd/vue.list.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('VueList Component created successfully.');
        }
    }

    /**
     * Create a Vue component file for the module.
     *
     * @return void
     * @throws FileNotFoundException
     */
    private function createVueView()
    {
        $path = $this->module_path."/components/{$this->module}View.vue";

        if ($this->alreadyExists($path)) {
            $this->error('VueView Component already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/frontEnd/vue.view.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('VueView Component created successfully.');
        }
    }

    /**
     * Create a Vue component file for the module.
     *
     * @return void
     * @throws FileNotFoundException
     */
    private function createVueForm()
    {
        $path = $this->module_path."/components/{$this->module}Form.vue";

        if ($this->alreadyExists($path)) {
            $this->error('VueForm Component already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/frontEnd/vue.form.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('VueForm Component created successfully.');
        }
    }

    /**
     * Create a Vue component file for the module.
     *
     * @return void
     * @throws FileNotFoundException
     */
    private function createStore()
    {
        $path = $this->module_path.'/store/store.js';

        if ($this->alreadyExists($path)) {
            $this->error('Store already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/frontEnd/store.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('Store created successfully.');
        }
    }

    /**
     * Create a Vue component file for the module.
     *
     * @return void
     * @throws FileNotFoundException
     */
    private function createStoreTypes()
    {
        $path = $this->module_path.'/store/types.js';

        if ($this->alreadyExists($path)) {
            $this->error('Types already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/frontEnd/store.types.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('Types created successfully.');
        }
    }

    /**
     * Create a Vue component file for the module.
     *
     * @return void
     * @throws FileNotFoundException
     */
    private function createStoreActions()
    {
        $path = $this->module_path.'/store/actions.js';

        if ($this->alreadyExists($path)) {
            $this->error('Actions already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/frontEnd/store.actions.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('Actions created successfully.');
        }
    }

    /**
     * Create a Vue component file for the module.
     * @return void
     * @throws FileNotFoundException
     */
    private function createRoutes()
    {
        $path = $this->module_path.'/routes.js';

        if ($this->alreadyExists($path)) {
            $this->error('Vue Routes already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/frontEnd/routes.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('Vue Routes created successfully.');
        }
    }

    /**
     * @return void
     * @throws FileNotFoundException
     */
    private function createApi()
    {
        $path = $this->module_path.'/api/index.js';

        if ($this->alreadyExists($path)) {
            $this->error('Api file already exists!');
        } else {
            $stub = $this->files->get(base_path('stubs/frontEnd/api.stub'));
            $this->createFileWithStub($stub, $path);
            $this->info('Api file created successfully.');
        }
    }
}
