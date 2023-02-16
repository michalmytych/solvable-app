<?php

namespace App\Contracts\ExternalCompiler;

use GuzzleHttp\Psr7\Response;

interface ExternalCompilerClientInterface
{
    /**
     * Initialize service, throw exceptions on errors.
     */
    public function init();

    /**
     * Post data to external service, get response data as Collection.
     */
    public function postCodeToExecute(array $data): Response;

    /**
     * Get name of external service.
     */
    public function getName(): string;
}
