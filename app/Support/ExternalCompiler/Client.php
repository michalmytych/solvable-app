<?php

namespace App\Support\ExternalCompiler;

use Illuminate\Support\Str;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client as BaseClient;
use App\Exceptions\CurlError3Exception;
use GuzzleHttp\Exception\RequestException;
use App\Exceptions\ExternalServiceInitializationException;
use App\Contracts\ExternalCompiler\ExternalCompilerClientInterface;

class Client extends BaseClient implements ExternalCompilerClientInterface
{
    private const NAME = 'Jdoodle';

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
        $response = $this->checkCreditSpent();

        $creditSpent = data_get(json_encode($response->getBody(), true), 'used');

        if ((int)$creditSpent >= self::REQUESTS_PER_DAY) {
            throw new ExternalServiceInitializationException();
        }
    }

    /**
     * Post solution code to be executed at external service.
     *
     * @param array $data
     * @return Response
     * @throws CurlError3Exception
     */
    public function postCodeToExecute(array $data): Response
    {
        return $this->templateRequest(fn() => $this->post(
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
    }

    /**
     * Request external service and get amount of request that was made
     * by client in last 24 hours.
     *
     * @return Response
     * @throws CurlError3Exception
     */
    private function checkCreditSpent(): Response
    {
        return $this->templateRequest(fn() => $this->post('/credit-spent'));
    }

    /**
     * Get name of client's external service.
     *
     * @return string
     */
    public function getName(): string
    {
        return Str::slug(self::NAME);
    }

    /**
     * Wrapper for pure GuzzleHttp requests, with specific exception rethrow.
     *
     * @param callable $request
     * @return mixed
     * @throws CurlError3Exception
     */
    private function templateRequest(callable $request): mixed
    {
        try {
            return $request();
        } catch (RequestException $exception) {
            if (Str::of($exception->getMessage())->contains('cURL error 3')) {
                throw new CurlError3Exception(
                    'Request error: check provided ' . self::NAME . ' service credentials, thrown '
                );
            }

            throw $exception;
        }
    }
}
