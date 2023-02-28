<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

/**
 * Class MakeService.
 *
 * @author  getsolaris (https://github.com/getsolaris)
 */
class MakeService extends GeneratorCommand
{
    use ValidatesMakeRequest;

    const STUB_PATH = __DIR__ . '/Stubs/';

    protected $signature = 'make:service {name : Create a service class} {--i : Create a service interface}';

    protected $description = 'Create a new service class and contract';

    protected $type = 'Service';

    protected function getStub() {}

    protected function getServiceStub(): string
    {
        return self::STUB_PATH . 'service.stub';
    }

    protected function getInterfaceStub(): string
    {
        return self::STUB_PATH . 'interface.stub';
    }

    protected function getServiceInterfaceStub(): string
    {
        return self::STUB_PATH . 'service.interface.stub';
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
                $this->buildServiceClass($name, $isInterface)
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
                    $this->buildServiceInterface($this->getNameInput())
                )
            );

            $message .= ' and Interface';
        }

        $this->info($message . ' created successfully.');

        return true;
    }

    protected function buildServiceClass(string $name, $isInterface): string
    {
        $stub = $this->files->get(
            $isInterface ? $this->getServiceInterfaceStub() : $this->getServiceStub()
        );

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    protected function buildServiceInterface(string $name): string
    {
        $stub = $this->files->get($this->getInterfaceStub());

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Services';
    }
}