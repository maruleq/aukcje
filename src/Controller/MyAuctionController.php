<?php

/*
 * Aplikacja Aukcje została zbudowana podczas kursu
 * Symphony 3 na strefakursow.pl i następnie dostosowana do Symfony 4
 */

namespace App\Controller;

use App\Entity\Auction;
use App\EventDispatcher\AuctionEvent;
use App\EventDispatcher\Events;
use App\Form\AuctionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Szczegóły MyAuctionController
 *
 * @author Marek Grabowski
 */
class MyAuctionController extends Controller {
    
    public function indexAction() {

        $this->denyAccessUnlessGranted("ROLE_USER");

        $entityManager = $this->getDoctrine()->getManager();
        $auctions = $entityManager
                ->getRepository(Auction::class)
                ->findBy(['owner' => $this->getUser()]);

        return $this->render("MyAuction/index.html.twig", ["auctions" => $auctions]);
    
    }
    
    public function detailsAction(Auction $auction) {
        
        if ($auction->getStatus() === Auction::STATUS_FINISHED) {

            return $this->render('Auction/finished.html.twig', ['auction' => $auction]);
        }
        /*
         * Formularz zabezpieczający przycisk "Usuń"
         */
        $deleteForm = $this->createFormBuilder()
                ->setAction($this->generateUrl('auction_delete', ['id' => $auction->getId()]))
                ->setMethod(Request::METHOD_DELETE)
                ->add('submit', SubmitType::class, ['label' => 'Usuń'])
                ->getForm();
        /*
         * Formularz zabezpieczający przycisk "Zakończ"
         */
        $finishForm = $this->createFormBuilder()
                ->setAction($this->generateUrl('auction_finish', ['id' => $auction->getId()]))
                ->add('submit', SubmitType::class, ['label' => 'Zakończ'])
                ->getForm();

        
        return $this->render('MyAuction/details.html.twig', [
            'auction' => $auction,
            'deleteForm' => $deleteForm->createView(),
            'finishForm' => $finishForm->createView()
        ]);
    }
}
