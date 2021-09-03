<?php

namespace App\Support\ExternalCompiler;

use Illuminate\Support\Str;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use GuzzleHttp\Client as BaseClient;
use App\Exceptions\CurlError3Exception;
use GuzzleHttp\Exception\RequestException;
use App\Exceptions\ExternalServiceInitializationException;
use App\Contracts\ExternalCompiler\ExternalCompilerClientInterface;

class Client extends BaseClient implements ExternalCompilerClientInterface
{
    /**
     * Name of the external compiler service.
     *
     * @var string
     */
    private string $name = 'Jdoodle';

    /**
     * Limit of requests allowed in free plan.
     */
    public const REQUESTS_PER_DAY = 200;

    /**
     * Initialize external service client.
     *
     * @throws ExternalServiceInitializationException|CurlError3Exception
     */
    public function init()
    {
        $creditSpent = $this->checkCreditSpent()->get('used');

        if ((int)$creditSpent >= self::REQUESTS_PER_DAY) {
            throw new ExternalServiceInitializationException();
        }
    }

    /**
     * Post solution code to be executed at external service.
     *
     * @param array $data
     * @return Collection
     * @throws CurlError3Exception
     */
    public function postCodeToExecute(array $data): Collection
    {
        $response = $this->templateRequest(fn() => $this->post(
            '/execute',
            [
                'json' => [
                    'clientId' => config('services.external-compiler-client.client-id'),
                    'clientSecret' => config('services.external-compiler-client.client-secret'),
                    'script' => $data['script'],
                    'language' => $data['language'],
                    'versionIndex' => $data['versionIndex']
                ],
            ]
        ));

        return $this->getDecodedResponseData($response);
    }

    /**
     * Request external service and get amount of request that was made
     * by client in last 24 hours.
     *
     * @return Collection
     * @throws CurlError3Exception
     */
    private function checkCreditSpent(): Collection
    {
        $response = $this->templateRequest(fn() => $this->post('/credit-spent'));

        return $this->getDecodedResponseData($response);
    }

    /**
     * Get response decoded from JSON format.
     *
     * @param Response $response
     * @return Collection
     */
    private function getDecodedResponseData(Response $response): Collection
    {
        return collect(
            json_decode($response->getBody()->getContents())
        );
    }

    /**
     * Get name of client's external service.
     *
     * @return string
     */
    public function getName(): string
    {
        return Str::slug($this->name);
    }

    /**
     * Wrapper for pure GuzzleHttp requests, with specific exception rethrow.
     *
     * @param callable $request
     * @return mixed
     * @throws CurlError3Exception
     */
    private function templateRequest(callable $request)
    {
        try {
            return $request();
        } catch (RequestException $exception) {
            if (Str::of($exception->getMessage())->contains('cURL error 3')) {
                throw new CurlError3Exception(
                    'Request error: check provided ' . $this->name . ' service credentials, thrown '
                );
            }

            throw $exception;
        }
    }
}
