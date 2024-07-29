<?php
declare(strict_types=1);

namespace App\Console\Commands\Development;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use JetBrains\PhpStorm\Pure;
use function app_path;
use function base_path;
use function class_basename;

class MakeModuleCommand extends Command
{
    protected Filesystem $files;
    protected $signature = 'make:module {module}
    {--entity= : "Сущность в модуле" / "Пусто, если совпадает"}';
    protected $description = 'Создание Модуля for front-end and back-end';
    protected Stringable $module;
    protected Stringable $entity;

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
        $this->module = Str::of(class_basename($this->argument('module')))->studly()->singular();
        $entity = empty($this->option('entity')) ? $this->argument('module') : $this->option('entity');
        $this->entity = Str::of(class_basename($entity))->studly()->singular();

        $this->createMigration();
        $backEndModule->create($this->module, $this->entity);
        $frontEndModule->create($this->module, $this->entity);
        $this->createFactory();
        $this->createTest();
    }

   protected function createModel()
    {
        $namespace = 'Modules/' . $this->module . '/Entity/';
        $module_path = app_path($namespace);

        $this->makeDirectory($module_path);

        $this->call('make:model', [
            'name' => $namespace . $this->module,
        ]);
    }

    protected function createMigration()
    {
        $table = $this->entity->plural()->snake();

        try {
            $this->call('make:migration', [
                'name' => "create_{$table}_table",
                '--create' => $table,
            ]);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    protected function createFactory()
    {
        $this->call('make:factory', [
            'name' => $this->entity . 'Factory',
            '--model' => "$this->entity",
        ]);
    }


    /**
     * @throws FileNotFoundException
     */
    protected function createTest()
    {
        $path = base_path('tests/Feature/' . $this->entity . 'Test.php');

        if ($this->alreadyExists($path)) {
            $this->error('Test file already exists!');
        } else {
            $stub = (new Filesystem)->get(base_path('stubs/test.stub'));

            $this->createFileWithStub($stub, $path);

            $this->info('Tests created successfully.');
        }
    }


    #[Pure]
    protected function alreadyExists(string $path): bool
    {
        return $this->files->exists($path);
    }

    protected function makeDirectory(string $path): string
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    protected function createFileWithStub($stub, $path)
    {

        $this->makeDirectory($path);

        $content = str_replace([
            'DummyRootNamespace',
            'DummySingular',
            'DummyEntitySingular',
            'DummyPlural',
            'DummyEntityPlural',
            'DUMMY_VARIABLE_SINGULAR',
            'DUMMY_VARIABLE_PLURAL',
            'dummyVariableSingular',
            'dummyVariablePlural',
            'dummy-plural',

            'dummyVariableEntitySingular',
            'dummyVariableEntityPlural',
            'dummy-entity-plural',
        ], [
            App::getNamespace(),
            $this->module,
            $this->entity,
            $this->module->pluralStudly(),
            $this->entity->pluralStudly(),
            $this->module->snake()->upper(),
            $this->module->plural()->snake()->upper(),
            lcfirst((string)$this->module),
            lcfirst((string)$this->module->pluralStudly()),
            lcfirst((string)$this->module->plural()->snake('-')),
            lcfirst((string)$this->entity),
            lcfirst((string)$this->entity->pluralStudly()),
            lcfirst((string)$this->entity->plural()->snake('-')),
        ],
            $stub
        );

        $this->files->put($path, $content);
    }
}
