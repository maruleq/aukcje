<?php

namespace App\Tests\Service;

use App\Service\DateService;
use PHPUnit\Framework\TestCase;

class TestDateService extends TestCase {
    
    public function testGetDay() {
        
        $dateService = new DateService();
        
        $this->assertEquals(19, $dateService->getDay(new \DateTime("2019-02-19")), "Powinien być zwrócony dzień 19");
        $this->assertEquals(1, $dateService->getDay(new \DateTime("2019-02-01")), "Powinien być zwrócony dzień 1");
    }
}
