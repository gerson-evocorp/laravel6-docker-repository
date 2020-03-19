<?php

namespace App\Console\Commands;

use Nwidart\Modules\Commands\GeneratorCommand;
use Illuminate\Support\Str;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Exception;

class ServiceMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;
    
    /**
     * The name of argument name.
     *
     * @var string
     */
    protected $argumentName = 'service';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service for the specified module';

    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        $this->checkIfAllArguments();
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $servicePath = GenerateConfigReader::read('service');

        return $path . $servicePath->getPath() . '/' . $this->getRepositoyName() . '.php';
    }

    /**
     * Check if contains arguments required
     * @return bool
     */
    public function checkIfAllArguments()
    {
        $arguments = $this->arguments();
        if (!isset($arguments['service'])){
            throw new Exception('Make sure you are passing the service name');
        }
        if (!isset($arguments['repository'])){
            throw new Exception('Make sure you are passing the repository name');
        }
        if (!isset($arguments['module'])){
            throw new Exception('Make sure you are passing the module name');
        }
    }

    /**
     * @return mixed
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());
        $myStubPath = realpath(__DIR__).'/stubs';
        
        $stub = new Stub($this->getStubName(), [
            'NAME'              => $this->getRepositoyName(),
            'REPOSITORY'        => $this->getRepositoryName(),
            'LOWER_REPOSITORY'  => $this->getRepositoryNameLower(),
            'NAMESPACE'         => $this->getClassNamespace($module),
            'CLASS'             => $this->getClass(),
            'LOWER_NAME'        => $module->getLowerName(),
            'MODULE'            => $this->getModuleName(),
            'STUDLY_NAME'       => $module->getStudlyName(),
            'MODULE_NAMESPACE'  => $this->laravel['modules']->config('namespace'),
        ]);
        $stub->setBasePath($myStubPath);
        return $stub->render();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        $arguments = [
            ['service', InputArgument::REQUIRED, 'The name of service will be created.'],
            ['repository', InputArgument::REQUIRED, 'The name of the model that will be injected into the service.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
        return $arguments;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['plain', 'p', InputOption::VALUE_NONE, 'Generate a plain service', null],
        ];
    }

    /**
     * Get the stub file name based on the options
     * @return string
     */
    private function getStubName()
    {
        if ($this->option('plain') === true) {
            $stub = '/service-plain.stub';
        } else {
            $stub = '/service.stub';
        }

        return $stub;
    }

    /** 
     * Get repository name base on the options
     * @return string
    */
    public function getRepositoryName()
    {
        return $this->argument('repository');
    }

    /** 
     * Get repository name lower case
     * @return string
    */
    public function getRepositoryNameLower()
    {
        return lcfirst($this->argument('repository'));
    }

    /**
     * @return mixed|string
     */
    private function getRepositoyName()
    {
        return Str::studly($this->argument('service'));
    }

    /**
     * Get default namespace.
     *
     * @return string
     */
    public function getDefaultNamespace() : string
    {
        $module = $this->laravel['modules'];

        return $module->config('paths.generator.service.namespace') ?: $module->config('paths.generator.service.path', 'Repositories');
    }
}