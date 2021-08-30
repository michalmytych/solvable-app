<?php

namespace App\Contracts\ExternalCompiler;

use Illuminate\Support\Collection;

interface ExternalCompilerClientInterface
{
    /**
     * Initialize service, throw exceptions on errors.
     *
     * @return mixed
     */
    public function init();

    /**
     * Post data to external service, get response data as Collection.
     *
     * @param array $data
     * @return Collection
     */
    public function postCodeToExecute(array $data): Collection;

    /**
     * Get name of external service.
     *
     * @return string
     */
    public function getName(): string;
}
