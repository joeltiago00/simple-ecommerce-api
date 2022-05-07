<?php

namespace App\Console\Commands;

use App\Exceptions\Respository\RepositoryNotCreated;
use App\Exceptions\Stub\StubNotFound;
use App\Exceptions\Stub\StubRepositoryModelNotSet;
use App\Exceptions\Stub\StubRepositoryNameNotSet;
use App\Exceptions\Stub\StubRepositoryNamespaceNotSet;
use Illuminate\Console\Command;

class CreateRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {repository} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to create a new repository.';

    /**
     * @var string|bool
     */
    private string|bool $model = false;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws RepositoryNotCreated
     * @throws StubNotFound
     * @throws StubRepositoryModelNotSet
     * @throws StubRepositoryNameNotSet
     * @throws StubRepositoryNamespaceNotSet
     */
    public function handle()
    {
        if (!is_null($this->option('model')))
            $this->setModel($this->option('model'));

        $argument = $this->setArgument(mb_strtolower($this->argument('repository')));

        $name = $this->setRepositoryName($argument);

        $namespace = $this->setNamespace($argument);

        $folder = $this->setFolder($argument);

        $stub = $this->getStub();

        $stub = $this->editStub($stub, $name, $namespace, $this->model);

        $this->createRepository($stub, $name, $folder);

        $this->info("Repository created successfully.");

        return 0;
    }

    /**
     * @param string $repository_name
     * @return string
     */
    private function setRepositoryName(string $repository_name): string
    {
        $repository_name = explode('/', $repository_name);

        return ucfirst(end($repository_name));
    }

    /**
     * @param string $name
     * @return string
     */
    private function setNamespace(string $name)
    {
        $namespace = explode('/', $name);

        if (count($namespace) === 1) {
            return 'App\Repositories';
        }

        $repository_namespace = '';

        for ($i = 0; $i < (count($namespace) - 1); $i++) {
            if ($i === (count($namespace) - 2)) {
                $repository_namespace .= sprintf("%s", ucfirst($namespace[$i]));

                return sprintf('App\Repositories\%s', $repository_namespace);
            }

            $repository_namespace .= sprintf("%s\\", ucfirst($namespace[$i]));
        }
    }

    /**
     * @param string $name
     * @return string
     */
    private function setFolder(string $name): string
    {
        $namespace = explode('/', $name);

        if (count($namespace) === 1) {
            return '';

        }

        $folder = '';

        for ($i = 0; $i < (count($namespace) - 1); $i++) {
            if ($i === (count($namespace) - 2)) {
                $folder .= sprintf("%s", ucfirst($namespace[$i]));

                return sprintf('%s', $folder);
            }

            $folder .= sprintf("%s" . DIRECTORY_SEPARATOR, ucfirst($namespace[$i]));
        }
    }

    /**
     * @param string $argument
     * @return string
     */
    private function setArgument(string $argument): string
    {
        if (str_contains($argument, 'app/repositories/'))
            $argument = str_replace('app/repositories/', '', $argument);

        return $argument;
    }

    /**
     * @return string
     * @throws StubNotFound
     */
    private function getStub(): string
    {
        if (!$this->model) {
            if (!$stub = file_get_contents('/var/www/html/stubs/repository-without-model.stub'))
                throw new StubNotFound();
        } else {
            if (!$stub = file_get_contents('/var/www/html/stubs/repository-with-model.stub'))
                throw new StubNotFound();
        }

        return $stub;
    }

    /**
     * @param string $stub
     * @param string $name
     * @param string $namespace
     * @param string|false $model
     * @return string
     * @throws StubRepositoryModelNotSet
     * @throws StubRepositoryNameNotSet
     * @throws StubRepositoryNamespaceNotSet
     */
    private function editStub(string $stub, string $name, string $namespace, string|false $model)
    {
        if (!$model)
            return $this->editStubWithoutModel($stub, $name, $namespace);

        return $this->editStubWithModel($stub, $name, $namespace, $model);
    }

    /**
     * @param string $stub
     * @param string $name
     * @param string $namespace
     * @return string
     * @throws StubRepositoryNameNotSet
     * @throws StubRepositoryNamespaceNotSet
     */
    private function editStubWithoutModel(string $stub, string $name, string $namespace): string
    {
        if (!$stub = str_replace('RepositoryName', $name, $stub))
            throw new StubRepositoryNameNotSet();

        if (!$stub = str_replace('NamespaceRepository', $namespace, $stub))
            throw new StubRepositoryNamespaceNotSet();

        return $stub;
    }

    /**
     * @param string $stub
     * @param string $name
     * @param string $namespace
     * @param string $model
     * @return string
     * @throws StubRepositoryModelNotSet
     * @throws StubRepositoryNameNotSet
     * @throws StubRepositoryNamespaceNotSet
     */
    private function editStubWithModel(string $stub, string $name, string $namespace, string $model): string
    {
        if (!$stub = str_replace('RepositoryName', $name, $stub))
            throw new StubRepositoryNameNotSet();

        if (!$stub = str_replace('NamespaceRepository', $namespace, $stub))
            throw new StubRepositoryNamespaceNotSet();

        if (!$stub = str_replace('ModelRepository', $model, $stub))
            throw new StubRepositoryModelNotSet();

        return $stub;
    }

    /**
     * @param string $model
     * @return void
     */
    private function setModel(string $model)
    {
        $this->model = ucfirst($model);
    }

    /**
     * @param string $stub
     * @param string $name
     * @param string $folder
     * @return void
     * @throws RepositoryNotCreated
     */
    private function createRepository(string $stub, string $name, string $folder)
    {
        $path = sprintf('%s/Repositories/%s', app_path(), $folder);

        if (!file_exists($path))
            mkdir($path, 755, true);

        if (!file_put_contents(sprintf('%s/%s.php', $path ,$name), $stub))
            throw new RepositoryNotCreated();
    }
}
