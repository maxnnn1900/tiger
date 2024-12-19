<?php

declare(strict_types=1);

namespace Maxnnn1900\ProxySMSApi;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

class ProxySMSApi
{
    private string $apiUrl;

    private string $apiToken;

    private ClientInterface $httpClient;

    private RequestFactoryInterface $requestFactory;

    public function __construct(string $apiUrl, string $apiToken, ClientInterface $httpClient, RequestFactoryInterface $requestFactory)
    {
        $this->apiUrl = $apiUrl;
        $this->apiToken = $apiToken;
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
    }

    private function sendRequest(array $params = []): array
    {
        $params['token'] = $this->apiToken;

        $url = $this->apiUrl.'?'.http_build_query($params);
        $request = $this->requestFactory->createRequest('GET', $url);

        try {
            $response = $this->httpClient->sendRequest($request);

            if ($response->getStatusCode() !== 200) {
                return [
                    'code' => 'error',
                    'message' => 'HTTP Error: '.$response->getStatusCode(),
                ];
            }

            $body = $response->getBody()->getContents();

            return json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (\Exception $e) {
            return [
                'code' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function getNumber(string $country, string $service, ?int $rentTime = null): array
    {
        $params = [
            'action' => 'getNumber',
            'country' => $country,
            'service' => $service,
        ];

        if ($rentTime !== null) {
            $params['rent_time'] = $rentTime;
        }

        return $this->sendRequest($params);
    }

    public function getSms(string $activationId): array
    {
        return $this->sendRequest([
            'action' => 'getSms',
            'activation' => $activationId,
        ]);
    }

    public function cancelNumber(string $activationId): array
    {
        return $this->sendRequest([
            'action' => 'cancelNumber',
            'activation' => $activationId,
        ]);
    }

    public function getStatus(string $activationId): array
    {
        return $this->sendRequest([
            'action' => 'getStatus',
            'activation' => $activationId,
        ]);
    }
}