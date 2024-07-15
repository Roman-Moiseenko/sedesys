<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use JetBrains\PhpStorm\Pure;

class MakeModuleCommand extends Command
{
    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected Filesystem $files;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Module for front-end and back-end';

    /** @var Stringable */
    protected Stringable $module;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param Filesystem $files
     * @param MakeFrontEndModule $frontEndModule
     * @param MakeBackEndModule $backEndModule
     * @return void
     * @throws FileNotFoundException
     */
    public function handle(Filesystem $files, MakeFrontEndModule $frontEndModule, MakeBackEndModule $backEndModule)
    {
        $this->files = $files;

        $this->module = Str::of(class_basename($this->argument('name')))->studly()->singular();

        //$this->createModel();


        $this->createMigration();


        $backEndModule->create($this->module);



        $frontEndModule->create($this->module);

        $this->createFactory();

        $this->createTest();

    }

    /**
     * Create a model file for the module.
     *
     * @return void
     */
   protected function createModel()
    {
        $namespace = 'Modules/' . $this->module . '/Entity/';
        $module_path = app_path($namespace);

        $this->makeDirectory($module_path);

        $this->call('make:model', [
            'name' => $namespace . $this->module,
        ]);
    }

    /**
     * Create a migration file for the module.
     *
     * @return void
     */
    protected function createMigration()
    {
        $table = $this->module->plural()->snake();

        try {
            $this->call('make:migration', [
                'name' => "create_{$table}_table",
                '--create' => $table,
            ]);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * Create a factory file for the module.
     *
     * @return void
     */
    protected function createFactory()
    {
        $this->call('make:factory', [
            'name' => $this->module.'Factory',
            '--model' => "$this->module",
        ]);
    }

    /**
     * Create a test file for the module.
     *
     * @return void
     * @throws FileNotFoundException
     */
    protected function createTest()
    {
        $path = base_path('tests/Feature/'.$this->module.'Test.php');

        if ($this->alreadyExists($path)) {
            $this->error('Test file already exists!');
        } else {
            $stub = (new Filesystem)->get(base_path('stubs/test.stub'));

            $this->createFileWithStub($stub, $path);

            $this->info('Tests created successfully.');
        }
    }

    /**
     * Determine if the class already exists.
     *
     * @param  string  $path
     * @return bool
     */
    #[Pure]
    protected function alreadyExists($path)
    {
        return $this->files->exists($path);
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path): string
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    /**
     * @param $stub
     * @param $path
     * @return void
     */
    protected function createFileWithStub($stub, $path)
    {

        $this->makeDirectory($path);

        $content = str_replace([
            'DummyRootNamespace',
            'DummySingular',
            'DummyPlural',
            'DUMMY_VARIABLE_SINGULAR',
            'DUMMY_VARIABLE_PLURAL',
            'dummyVariableSingular',
            'dummyVariablePlural',
            'dummy-plural',
        ], [
            App::getNamespace(),
            $this->module,
            $this->module->pluralStudly(),
            $this->module->snake()->upper(),
            $this->module->plural()->snake()->upper(),
            lcfirst((string)$this->module),
            lcfirst((string)$this->module->pluralStudly()),
            lcfirst((string)$this->module->plural()->snake('-')),
        ],
            $stub
        );

        $this->files->put($path, $content);
    }
}
