<?php

/*
 * Aplikacja Aukcje została zbudowana podczas kursu
 * Symphony 3 na strefakursow.pl i następnie dostosowana do Symfony 4
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\BidType;
use App\Entity\Auction;

/**
 * Szczegóły AuctionController
 *
 * @author Marek Grabowski
 */
class AuctionController extends Controller
{
    
    /*
     * Wyświetlanie wszystkich aukcji
     */
    public function indexAction() {
        
        $entityManager = $this->getDoctrine()->getManager();
        $auctions = $entityManager->getRepository(Auction::class)->findBy(['status' => Auction::STATUS_ACTIVE]);
        
        return $this->render('Auction/index.html.twig', [
            'auctions' => $auctions,
        ]);
    }
    
    /*
     * Wyświetlanie szczegółów aukcji
     */
    public function detailsAction(Auction $auction) {
        
        if ($auction->getStatus() === Auction::STATUS_FINISHED) {

            return $this->render('Auction/finished.html.twig', ['auction' => $auction]);
        }
       
        /*
         * Formularz zabezpieczający przycisk "Kup"
         */
        $buyForm = $this->createFormBuilder()
                ->setAction($this->generateUrl('offer_buy', ['id' => $auction->getId()]))
                ->add('submit', SubmitType::class, ['label' => 'Kup'])
                ->getForm();
        /*
         * Formularz zabezpieczający przycisk "Licytuj"
         */
        $bidForm = $this->createForm(BidType::class, null, [
            'action' => $this->generateUrl('offer_bid', ['id' => $auction->getId()])]);
        
        return $this->render('Auction/details.html.twig', [
            'auction' => $auction,
            'buyForm' => $buyForm->createView(),
            'bidForm' => $bidForm->createView()
        ]);
    }

}
