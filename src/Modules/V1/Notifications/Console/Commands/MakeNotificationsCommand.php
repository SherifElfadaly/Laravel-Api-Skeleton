<?php namespace App\Modules\V1\Notifications\Console\Commands;

use Caffeinated\Modules\Console\GeneratorCommand;

class MakeNotificationsCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module:notification
        {slug : The slug of the module.}
        {name : The name of the notification class.}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module notification class';
    /**
     * String to store the command type.
     *
     * @var string
     */
    protected $type = 'Module notification';
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/notification.stub';
    }
    /**
     * Get the destination class path.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getPath($name)
    {
        return module_path($this->argument('slug'), 'Notifications/'.$name.'.php');
    }
    /**
     * Parse the name and format according to the root namespace.
     *
     * @param string $name
     *
     * @return string
     */
    protected function qualifyClass($name)
    {
        return $name;
    }
    /**
     * Replace namespace in notification stub.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getNamespace($name)
    {
        return module_class($this->argument('slug'), 'Notifications');
    }
}