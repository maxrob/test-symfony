<?php

namespace ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FoodControllerTest extends WebTestCase
{
    public function testAll()
    {
        $client = static::createClient();
        $client->request('GET', '/api/foods');
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testGet()
    {
        $client = static::createClient();

        $client->request('GET', '/api/foods/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $client->request('GET', '/api/foods/x');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());

        $client->request('GET', '/api/foods/9999');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            "Not found this food"
        );
    }

    public function testSearch()
    {
        $client = static::createClient();

        $client->request('POST', '/api/foods/search');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $client->request('POST', '/api/foods/search', [
            "search" => "Farines"
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $client->request('POST', '/api/foods/search', [
            "search" => "toto"
        ]);
        $this->assertEquals(500, $client->getResponse()->getStatusCode());
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            "No foods for name toto"
        );
    }
}
