<?php

namespace App\Contracts\ExternalCompiler;

use GuzzleHttp\Psr7\Response;

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
     * @return Response
     */
    public function postCodeToExecute(array $data): Response;

    /**
     * Get name of external service.
     *
     * @return string
     */
    public function getName(): string;
}
