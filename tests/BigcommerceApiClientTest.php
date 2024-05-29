<?php

use PHPUnit\Framework\TestCase;
use Itsyashu\BigcommerceApiSdk\BigcommerceApiClient;

class BigcommerceApiClientTest extends TestCase
{
    protected $storeHash = '{storeHash}';
    protected $authToken = '{authToken}';
    protected $client;

    protected function setUp(): void
    {
        $this->client = new BigcommerceApiClient($this->storeHash, $this->authToken);
    }

    public function testGetProducts()
    {
        $response = $this->client->get('v3/catalog/products');
        $this->assertNotNull($response);
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('response', $response);
    }

    public function testPostProduct()
    {
        $data = [
            "name" => "Smith Journal 13",
            "type" => "physical",
            "sku" => "SM-13",
            "description" => "Test Description Here",
            "weight" => 9999999999,
            "width" => 9999999999,
            "depth" => 9999999999,
            "height" => 9999999999,
            "price" => 0.1,
        ];
        $response = $this->client->post('v3/catalog/products', $data);
        $this->assertNotNull($response);
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('response', $response);
    }

    public function testPutProduct()
    {
        $data = [
            "name" => "Smith Journal 13",
            "type" => "physical",
            "sku" => "SM-13",
            "description" => "Test Description Here",
        ];
        $response = $this->client->put('v3/catalog/products/123', $data);
        $this->assertNotNull($response);
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('response', $response);
    }

    public function testDeleteProduct()
    {
        $response = $this->client->delete("v3/catalog/products/123");
        $this->assertNotNull($response);
        $this->assertArrayHasKey('status', $response);
    }

    public function testDummyProductRoute()
    {
        $response = $this->client->get("v3/catalog/products/dummy");
        $this->assertNotNull($response);
        $this->assertArrayHasKey('status', $response);
    }
}
