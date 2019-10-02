<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Auction;

class AuctionController extends AbstractController
{

    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $auctions = $entityManager->getRepository(Auction::class)->findAll();
        
        return $this->render('auction/index.html.twig', [
            'auctions' => $auctions,
        ]);
    }
    
    public function detailsAction($id)
    {
        return $this->render('auction/details.html.twig');
    }
}
