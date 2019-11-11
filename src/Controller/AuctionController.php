<?php

/*
 * Aplikacja Aukcje została zbudowana podczas kursu
 * Symphony 3 na strefakursow.pl i następnie dostosowana do Symfony 4
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\AuctionType;
use App\Entity\Auction;

/**
 * Szczegóły AuctionController
 *
 * @author Marek Grabowski
 */
class AuctionController extends AbstractController
{
    
    /*
     * Wyświetlanie wszystkich aukcji
     */
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $auctions = $entityManager->getRepository(Auction::class)->findAll();
        
        return $this->render('auction/index.html.twig', [
            'auctions' => $auctions,
        ]);
    }
    
    /*
     * Wyświetlanie szczegółów aukcji
     */
    public function detailsAction($id)
    {
        return $this->render('auction/details.html.twig');
    }
    
    /*
     * Formularz dodawania aukcji
     */
    public function addAction(Request $request)
    {
        $auction = new Auction();
        
        /*
         * Stworzenie formularza
         */
        $form = $this->createForm(AuctionType::class, $auction);
        
        /*
         * Przetworzenie danych z formularza
         * i przekierowanie do widoku wszystkich aukcji
         */
        if ($request->isMethod('post')){
            $form->handleRequest($request);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($auction);
            $entityManager->flush();
            
            return $this->redirectToRoute('auction_index');
        }
        
        /*
         * Wyswietlenie formularza
         */
        return $this->render('auction/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
