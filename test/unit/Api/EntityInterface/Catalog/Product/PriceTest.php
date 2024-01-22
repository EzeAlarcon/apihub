<?php

/**
 * BSeller Platform | B2W - Companhia Digital
 *
 * Do not edit this file if you want to update this module for future new versions.
 *
 * @category  SkuHubTest
 * @package   SkuHubTest
 *
 * @copyright Copyright (c) 2021 B2W Digital - BSeller Platform. (http://www.bseller.com.br).
 *
 */


namespace SkyHubTest\unit\Api\EntityInterface\Catalog\Product;

use PHPUnit\Framework\TestCase;
use SkyHub\Api;
use SkyHub\Api\EntityInterface\Catalog\Product\Price;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use SkyHub\Api\Service\ServiceJson;
use SkyHub\Api\Service\ClientBuilderInterface;

class PriceTest extends TestCase
{
    /** @var Api */
    protected $api;

    /** @var Price */
    protected $price;

    protected function setUp()
    {
        // Create a mock and queue two responses.
        $mock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], ''),
            new Response(202, ['Content-Length' => 0]),
            new RequestException("Error Communicating with Server", new Request('POST', 'test'))
        ]);

        $handler = HandlerStack::create($mock);
        $this->client = new Client(['handler' => $handler]);

        $this->builder = $this->createMock(ClientBuilderInterface::class);
        $this->builder->method('build')->willReturn($this->client);

        $this->service = new ServiceJson('http://www.example.com', [], [], $this->builder);

        $this->api = new Api('anyone@anyone.com', 'anything', null, 'https://api.skyhub.com', $this->service);
        $this->price = $this->api->productPrice()->entityInterface();
    }

    /**
     * @test
     */
    public function isProductPriceEntityInterfaceCorrectInstance()
    {
        $this->assertInstanceOf(Price::class, $this->price);
    }

    /**
     * @test
     * @depends isProductPriceEntityInterfaceCorrectInstance
     */
    public function checkDataToUpdate()
    {
        $sku = 'test';
        $price = 1.00;
        $promotionPrice = 0.90;
        $this->price->setSku($sku);
        $this->price->setPrice($price);
        $this->price->setPromotionalPrice($promotionPrice);

        $this->assertEquals($sku, $this->price->getSku());
        $this->assertEquals($price, $this->price->getPrice());
        $this->assertEquals($promotionPrice, $this->price->getPromotionalPrice());
        return $this->price;
    }

    /**
     * @test
     * @depends checkDataToUpdate
     */
    public function checkApiUpdate(Price $price)
    {
        $this->assertEquals(
            '200',
            $price->update()->statusCode()
        );
    }
}
