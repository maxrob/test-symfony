<?php

namespace Tests\ApiBundle\Service;

use ApiBundle\Service\ConvertService;
use PHPUnit\Framework\TestCase;

class ConvertServiceTest extends TestCase
{
    public function testCSVToArray()
    {
        $filename = './database/Table_Ciqual_2016.csv';
        $converter = new ConvertService();

        $result = $converter->csv_to_array($filename);

        $this->assertTrue(is_array($result));
        $this->assertCount(2642, $result);

        
        $this->assertTrue(is_array($result[0]));
        $this->assertCount(65, $result[0]);
    }
}