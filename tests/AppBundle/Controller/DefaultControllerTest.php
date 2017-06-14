<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testList()
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDetail()
    {
        $client = static::createClient();

        $client->request('GET', '/food/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
