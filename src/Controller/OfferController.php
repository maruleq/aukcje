<?php

/*
 * Aplikacja Aukcje została zbudowana podczas kursu
 * Symphony 3 na strefakursow.pl i następnie dostosowana do Symfony 4
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Auction;
use App\Entity\Offer;

/**
 * Szczegóły OfferController
 *
 * @author Marek Grabowski
 */
class OfferController extends Controller {
    
    public function buyAction(Auction $auction) {
        
        $offer = new Offer();
        $offer
            ->setAuction($auction)
            ->setType(Offer::TYPE_BUY)
            ->setPrice($auction->getPrice());
        
        $auction->setStatus(Auction::STATUS_FINISHED);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($auction);
        $entityManager->persist($offer);
        $entityManager->flush();
        
        return $this->redirectToRoute('auction_details', ['id' => $auction->getId()]);
    }
}
