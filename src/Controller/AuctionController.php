<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuctionController extends AbstractController
{

    public function index()
    {
        return $this->render('auction/index.html.twig', [
            'controller_name' => 'AuctionController',
        ]);
    }
}
