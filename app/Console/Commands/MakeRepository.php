<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class MakeRepository extends GeneratorCommand
{
    use ValidatesMakeRequest;

    const STUB_PATH = __DIR__ . '/Stubs/';

    protected $signature = 'make:repository {name : Create a repository class} {--i : Create a repository interface}';

    protected $description = 'Create a new repository class and contract';

    protected $type = 'Repository';

    protected function getStub() {}

    protected function getRepositoryStub(): string
    {
        return self::STUB_PATH . 'repository.stub';
    }

    protected function getInterfaceStub(): string
    {
        return self::STUB_PATH . 'interface.stub';
    }

    protected function getRepositoryInterfaceStub(): string
    {
        return self::STUB_PATH . 'repository.interface.stub';
    }

    public function handle(): bool
    {
        $isValid = $this->validateMakeRequest();

        if (!$isValid) {
            return false;
        }

        $name = $this->qualifyClass($this->getNameInput());
        $path = $this->getPath($name);

        $this->makeDirectory($path);
        $isInterface = $this->option('i');

        $this->files->put(
            $path,
            $this->sortImports(
                $this->buildRepositoryClass($name, $isInterface)
            )
        );

        $message = $this->type;

        if ($isInterface) {
            $interfaceName = $this->getNameInput() . 'Interface.php';
            $interfacePath = str_replace($this->getNameInput() . '.php', 'Contracts/', $path);

            $this->makeDirectory($interfacePath . $interfaceName);

            $this->files->put(
                $interfacePath . $interfaceName,
                $this->sortImports(
                    $this->buildRepositoryInterface($this->getNameInput())
                )
            );

            $message .= ' and Interface';
        }

        $this->info($message . ' created successfully.');

        return true;
    }

    protected function buildRepositoryClass(string $name, $isInterface): string
    {
        $stub = $this->files->get(
            $isInterface ? $this->getRepositoryInterfaceStub() : $this->getRepositoryStub()
        );

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    /**
     * @throws FileNotFoundException
     */
    protected function buildRepositoryInterface(string $name): string
    {
        $stub = $this->files->get($this->getInterfaceStub());

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Repositories';
    }
}