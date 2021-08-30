<?php

namespace App\Support\ExternalCompiler;

use Illuminate\Support\Str;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use GuzzleHttp\Client as BaseClient;
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
     * @throws ExternalServiceInitializationException
     */
    public function init()
    {
        $creditSpent = $this->checkCreditSpent()->get('used');

        if ((int) $creditSpent >= self::REQUESTS_PER_DAY) {
            throw new ExternalServiceInitializationException();
        }
    }

    public function postCodeToExecute(array $data): Collection
    {
        $response = $this->post(
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
        );

        return $this->getDecodedResponseData($response);
    }

    private function checkCreditSpent(): Collection
    {
        $response = $this->post('/credit-spent');

        return $this->getDecodedResponseData($response);
    }

    private function getDecodedResponseData(Response $response): Collection
    {
        return collect(
            json_decode($response->getBody()->getContents())
        );
    }

    public function getName(): string
    {
        return Str::slug($this->name);
    }
}
