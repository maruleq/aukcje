<?php

namespace App\EventDispatcher;

use App\Entity\Auction;
use Symfony\Component\EventDispatcher\Event;

class AuctionEvent extends Event
{
    /**
     * @var Auction
     */
    private $auction;

    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }

    /**
     * @return Auction
     */
    public function getAuction()
    {
        return $this->auction;
    }
}
