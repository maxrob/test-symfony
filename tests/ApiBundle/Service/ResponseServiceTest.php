<?php

namespace Tests\ApiBundle\Service;

use ApiBundle\Service\ResponseService;
use PHPUnit\Framework\TestCase;

class ResponseServiceTest extends TestCase
{
    public function testSuccess()
    {
        $response = new ResponseService();
        
        $data = [ "test" => "test" ];
        
        $success = $response->success($data);
        $this->assertEquals(200, $success->getStatusCode());
        $this->assertTrue(
            $success->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
        $this->assertTrue(array_key_exists("data", json_decode($success->getContent())));
    }

    public function testError()
    {
        $response = new ResponseService();

        $data = [ "test" => "test" ];
        
        $error404 = $response->error($data, 404);
        $this->assertEquals(404, $error404->getStatusCode());
        $this->assertTrue(
            $error404->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
        $this->assertTrue(array_key_exists("message", json_decode($error404->getContent())));
        
        $error500 = $response->error($data, 500);
        $this->assertEquals(500, $error500->getStatusCode());
        $this->assertTrue(
            $error500->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
        $this->assertTrue(array_key_exists("message", json_decode($error500->getContent())));

    }
}