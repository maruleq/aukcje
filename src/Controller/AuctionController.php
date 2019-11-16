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
use Psr\Log\LoggerInterface;
use App\Service\DateService;

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
    public function indexAction(DateService $dateService, LoggerInterface $logger) {
        
        $entityManager = $this->getDoctrine()->getManager();
        
        /*
         * Sortowanie wszystkich aukcji od kończących się
         */
        $auctions = $entityManager->getRepository(Auction::class)->findActiveOrdered();
        
        
        /*
         * Podgląd loggera w dev.log:
         * cat var/log/dev.log | grep app.INFO
         */
        $logger->info("Użytkownik wyświetlił listę aukcji");
        $logger->info("Aktualny dzień miesiąca to " . $dateService->getDay(new \DateTime()));
        
        return $this->render('Auction/index.html.twig', [
            'auctions' => $auctions,
        ]);
    }
    
    /*
     * Wyświetlanie szczegółów aukcji
     */
    public function detailsAction(Auction $auction) {
        
        if (!$this->isGranted('ROLE_USER')) {
            $this->addFlash("error", "Aby kupować musisz być zalogowany");
        }
        
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
