<?php

namespace App\Tests\Twig;

use App\Twig\DateExtension;
use PHPUnit\Framework\TestCase;

class TestDateExtension extends TestCase {
    
    public function testGetStyle() {

        $dateExtension = new DateExtension();
        
         $this->assertEquals("card-header bg-info", $dateExtension->auctionStyle(new \DateTime("+2 days")));
        $this->assertEquals("card-header bg-warning", $dateExtension->auctionStyle(new \DateTime("+20 minutes")));

}
}
