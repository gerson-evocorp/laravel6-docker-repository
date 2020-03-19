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


class RepositoryMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;
    
    /**
     * The name of argument name.
     *
     * @var string
     */
    protected $argumentName = 'repository';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository for the specified module';

    public function handle()
    {
        parent::handle();

        $this->handleOptionalServiceOption();
    }

    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        $this->checkIfAllArguments();
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $repositoryPath = GenerateConfigReader::read('repository');

        return $path . $repositoryPath->getPath() . '/' . $this->getRepositoyName() . '.php';
    }

    /**
     * Check if contains arguments required
     * @return bool
     */
    public function checkIfAllArguments()
    {
        $arguments = $this->arguments();
        if (!isset($arguments['repository'])){
            throw new Exception('Make sure you are passing the repository name');
        }
        if (!isset($arguments['model'])){
            throw new Exception('Make sure you are passing the model name');
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
            'MODEL'             => $this->getModelName(),
            'LOWER_MODEL'       => $this->getModelNameLower(),
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
            ['repository', InputArgument::REQUIRED, 'The name of repository will be created.'],
            ['model', InputArgument::REQUIRED, 'The name of the model that will be injected into the repository.'],
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
            ['plain', 'p', InputOption::VALUE_NONE, 'Generate a plain repository', null],
            ['service', 's', InputOption::VALUE_NONE, 'Flag to create associated service', null],
        ];
    }

    /**
     * Create the service file with the given model if service flag was used
     */
    private function handleOptionalServiceOption()
    {
        if ($this->option('service') === true) {
            $this->call('module:make-service', ['service' => $this->createServiceName(), 'repository' => $this->getRepositoyName(), 'module' => $this->argument('module')]);
        }
    }

    /**
     * Get the stub file name based on the options
     * @return string
     */
    private function getStubName()
    {
        if ($this->option('plain') === true) {
            $stub = '/repository-plain.stub';
        } else {
            $stub = '/repository.stub';
        }

        return $stub;
    }

    /** 
     * Get model name base on the options
     * @return string
    */
    public function getModelName()
    {
        return $this->argument('model');
    }

    /**
     * Create a proper service name:
     * ProductDetail: ProductDetailService
     * Product: ProductService
     * @return string
     */
    private function createServiceName()
    {
        return $this->argument('model').'Service';
    }

    /** 
     * Get model name lower case
     * @return string
    */
    public function getModelNameLower()
    {
        return Str::lower($this->argument('model'));
    }

    /**
     * @return mixed|string
     */
    private function getRepositoyName()
    {
        return Str::studly($this->argument('repository'));
    }

    /**
     * Get default namespace.
     *
     * @return string
     */
    public function getDefaultNamespace() : string
    {
        $module = $this->laravel['modules'];

        return $module->config('paths.generator.repository.namespace') ?: $module->config('paths.generator.repository.path', 'Repositories');
    }
}