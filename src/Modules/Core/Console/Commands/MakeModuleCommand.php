<?php

namespace App\Modules\Core\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Caffeinated\Modules\RepositoryManager;
use Symfony\Component\Console\Helper\ProgressBar;

class MakeModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:module
        {slug : The slug of the module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module';

    /**
     * The modules instance.
     *
     * @var RepositoryManager
     */
    protected $module;

    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Array to store the configuration details.
     *
     * @var array
     */
    protected $container;

    /**
     * Array of folder mappings.
     *
     * @var Array
     */
    protected $mapping = [
        'Database/Factories'  => 'Database/Factories',
        'Database/Migrations' => 'Database/Migrations',
        'Database/Seeds'      => 'Database/Seeds',
        'Http/Controllers'    => 'Http/Controllers',
        'Http/Requests'       => 'Http/Requests',
        'Http/Resources'      => 'Http/Resources',
        'ModelObservers'      => 'ModelObservers',
        'Providers'           => 'Providers',
        'Repositories'        => 'Repositories',
        'Services'            => 'Services',
        'Routes'              => 'Routes',
        'Errors'              => 'Errors',
    ];

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     * @param RepositoryManager $module
     */
    public function __construct(Filesystem $files, RepositoryManager $module)
    {
        parent::__construct();

        $this->files = $files;
        $this->module = $module;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->container['slug']        = Str::slug($this->argument('slug'));
        $this->container['name']        = Str::studly($this->container['slug']);
        $this->container['version']     = '1.0';
        $this->container['description'] = 'This is the description for the ' . $this->container['name'] . ' module.';
        $this->container['location']    = config('modules.default_location');
        $this->container['provider']    = config("modules.locations.{$this->container['location']}.provider");
        $this->container['basename']    = Str::studly($this->container['slug']);
        $this->container['namespace']   = config("modules.locations.{$this->container['location']}.namespace").$this->container['basename'];

        return $this->generate();
    }

    /**
     * Generate the module.
     */
    protected function generate()
    {
        $steps = [
            'Generating module...' => 'generateModule',
            'Optimizing module cache...' => 'optimizeModules',
            'Generating migrations...' => 'generateMigration',
        ];

        $progress = new ProgressBar($this->output, count($steps));
        $progress->start();

        foreach ($steps as $message => $function) {
            $progress->setMessage($message);

            $this->$function();

            $progress->advance();
        }

        $progress->finish();

        event($this->container['slug'] . '.module.made');

        $this->info("\nModule generated successfully.");
    }

    /**
     * Generate defined module folders.
     */
    protected function generateModule()
    {
        $location = $this->container['location'];
        $root     = module_path(null, '', $location);
        $manifest = config("modules.locations.$location.manifest") ?: 'module.json';
        $provider = config("modules.locations.$location.provider") ?: 'ModuleServiceProvider';

        if (!$this->files->isDirectory($root)) {
            $this->files->makeDirectory($root);
        }

        $directory = module_path(null, $this->container['basename'], $location);
        $source    = __DIR__ . '/Stubs/Module';

        $this->files->makeDirectory($directory);

        $sourceFiles = $this->files->allFiles($source, true);

        if (!empty($this->mapping)) {
            $search = array_keys($this->mapping);
            $replace = array_values($this->mapping);
        }

        foreach ($sourceFiles as $file) {
            $contents = $this->replacePlaceholders($file->getContents());
            $subPath = $file->getRelativePathname();

            if (!empty($this->mapping)) {
                $subPath = str_replace($search, $replace, $subPath);
            }

            $filePath = $directory . '/' . $subPath;
            
            // if the file is module.json, replace it with the custom manifest file name
            if ($file->getFilename() === 'module.json' && $manifest) {
                $filePath = str_replace('module.json', $manifest, $filePath);
            }
            
            // if the file is ModuleServiceProvider.php, replace it with the custom provider file name
            if ($file->getFilename() === 'ModuleServiceProvider.php') {
                $filePath = str_replace('ModuleServiceProvider', $provider, $filePath);
            }
            $filePath = $this->replacePlaceholders($filePath);
            
            $dir = dirname($filePath);
            
            if (! $this->files->isDirectory($dir)) {
                $this->files->makeDirectory($dir, 0755, true);
            }

            $this->files->put($filePath, $contents);
        }
    }

    protected function replacePlaceholders($contents)
    {
        $modelName = \Str::camel($this->container['slug']);
        $modelNameSingular = \Str::singular($modelName);

        $find = [
            'DummyFactory',
            'DummyModelName',
            'DummyModuleSlug',
            'DummyModule',
            'DummyModel',
            'DummyDatabaseSeeder',
            'DummyTableSeeder',
            'DummyController',
            'DummyService',
            'DummyRepository',
            'DummyErrors',
            'InsertDummy',
            'UpdateDummy',
            'DummyResource',
            'DummyObserver',
            'DummyTableName',
            'DummyRoutePrefix',
        ];

        $replace = [
            ucfirst($modelNameSingular) . 'Factory',
            $modelNameSingular,
            $this->container['slug'],
            ucfirst($modelName),
            ucfirst($modelNameSingular),
            ucfirst($modelName) . 'DatabaseSeeder',
            ucfirst($modelName) . 'TableSeeder',
            ucfirst($modelNameSingular) . 'Controller',
            ucfirst($modelNameSingular) . 'Service',
            ucfirst($modelNameSingular) . 'Repository',
            ucfirst($modelName) . 'Errors',
            'Insert' . ucfirst($modelNameSingular),
            'Update' . ucfirst($modelNameSingular),
            ucfirst($modelNameSingular),
            ucfirst($modelNameSingular) . 'Observer',
            $modelName,
            $modelName,
        ];

        return str_replace($find, $replace, $contents);
    }

    /**
     * Reset module cache of enabled and disabled modules.
     */
    protected function optimizeModules()
    {
        return $this->callSilent('module:optimize');
    }

    /**
     * Generate table migrations.
     */
    protected function generateMigration()
    {
        $modelName = $this->container['slug'];
        return $this->callSilent('make:module:migration', ['slug' => $modelName, 'name' => 'create_' . $modelName . '_table']);
    }
}
