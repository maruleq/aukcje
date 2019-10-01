<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuctionController extends AbstractController
{

    public function indexAction()
    {
        return $this->render('auction/index.html.twig', [
            'title' => 'Lista aukcji',
        ]);
    }
    
    public function detailsAction()
    {
        return $this->render('auction/details.html.twig', [
            'title' => 'Szczegóły aukcji',
        ]);
    }
}
