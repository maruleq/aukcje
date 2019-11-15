<?php

/*
 * Aplikacja Aukcje została zbudowana podczas kursu
 * Symphony 3 na strefakursow.pl i następnie dostosowana do Symfony 4
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Auction;
use App\Entity\Offer;
use App\Form\BidType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Szczegóły OfferController
 *
 * @author Marek Grabowski
 */
class OfferController extends Controller {
    
    /*
     * Zakup przedmiotu aukcji
     */
    public function buyAction(Auction $auction) {
        
        $this->denyAccessUnlessGranted("ROLE_USER");
        
        $offer = new Offer();
        $offer
            ->setAuction($auction)
            ->setType(Offer::TYPE_BUY)
            ->setPrice($auction->getPrice());
        $auction
            ->setStatus(Auction::STATUS_FINISHED)
            ->setExpiresAt(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($auction);
        $entityManager->persist($offer);
        $entityManager->flush();
        
        $this->addFlash("success", "Kupiłeś przedmiot {$auction->getTitle()} za kwotę {$offer->getPrice()} PLN");
        
        return $this->redirectToRoute('auction_details', ['id' => $auction->getId()]);
    }
    
    /*
     * Licytacja aukcji
     */
    public function bidAction(Request $request, Auction $auction) {
        
        $this->denyAccessUnlessGranted("ROLE_USER");
        
        $offer = new Offer();
        $bidForm = $this->createForm(BidType::class, $offer);
        
        $bidForm->handleRequest($request);
        
        if ($bidForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $lastOffer = $entityManager
                    ->getRepository(Offer::class)
                    ->findOneBy(['auction' => $auction], ['createdAt' => 'DESC']);
            
            if (isset($lastOffer)) {
                if ($offer->getPrice() <= $lastOffer->getPrice()) {
                    $this->addFlash("error", "Twoja oferta nie może być niższa niż {$lastOffer->getPrice()} PLN");
                    
                    return $this->redirectToRoute('auction_details', ['id' => $auction->getId()]);
                }
            } else {
                    if ($offer->getPrice() < $auction->getStartingPrice()) {
                        $this->addFlash("error", "Twoja oferta nie może być niższa od ceny wywoławczej");
                        
                        return $this->redirectToRoute('auction_details', ['id' => $auction->getId()]);
                    }
                
            }
            
            $offer
            ->setType(Offer::TYPE_BID)
            ->setAuction($auction);
        
            $entityManager->persist($offer);
            $entityManager->flush();
        
            $this->addFlash("success", "Założyłeś ofertę na przedmiot {$auction->getTitle()} na kwotę {$offer->getPrice()} PLN");
        } else {
            $this->addFlash("error", "Nie udało się zalicytować aukcji {$auction->getTitle()}");
        }
       
        return $this->redirectToRoute('auction_details', ['id' => $auction->getId()]);
    }
}
