<?php

namespace Itsyashu\BigcommerceApiSdk;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Throwable;

class BigcommerceApiClient
{
    protected $client;
    protected $storeHash;
    protected $authToken;

    public function __construct(string $storeHash, string $authToken)
    {
        $this->storeHash = $storeHash;
        $this->authToken = $authToken;

        $this->client    = new Client([
            'base_uri' => "https://api.bigcommerce.com/stores/$this->storeHash/",
            'headers'  => [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
                'X-Auth-Token' => $this->authToken
            ]
        ]);
    }

    public function get(string $uri, array $params = [])
    {
        return $this->handleRequest(function () use ($uri, $params) {
            $response = $this->client->get($uri, ['query' => $params]);
            return $this->getResponseData($response);
        });
    }

    public function post(string $uri, array $data)
    {
        return $this->handleRequest(function () use ($uri, $data) {
            $response = $this->client->post($uri, ['json' => $data]);
            return $this->getResponseData($response);
        });
    }

    public function put(string $uri, array $data)
    {
        return $this->handleRequest(function () use ($uri, $data) {
            $response = $this->client->put($uri, ['json' => $data]);
            return $this->getResponseData($response);
        });
    }

    public function delete(string $uri)
    {
        return $this->handleRequest(function () use ($uri) {
            $response = $this->client->delete($uri);
            return $this->getResponseData($response);
        });
    }

    protected function handleRequest(callable $callback)
    {
        try {
            return $callback();
        } catch (RequestException|Throwable $e) {
            return $this->handleException($e);
        }
    }

    protected function handleException(Throwable $e): array
    {
        $status   = $e->getResponse() ? $e->getResponse()->getStatusCode() : null;
        $response = $e->getResponse() ? json_decode($e->getResponse()->getBody()->getContents(), true) : null;

        return [
            'status'   => $status,
            'message'  => $e->getMessage(),
            'response' => $response
        ];
    }

    protected function getResponseData($response): array
    {
        return [
            'status'   => $response->getStatusCode(),
            'response' => json_decode($response->getBody()->getContents(), true)
        ];
    }
}