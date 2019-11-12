<?php

/*
 * Aplikacja Aukcje została zbudowana podczas kursu
 * Symphony 3 na strefakursow.pl i następnie dostosowana do Symfony 4
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function indexAction() {
        
        $entityManager = $this->getDoctrine()->getManager();
        $auctions = $entityManager->getRepository(Auction::class)->findAll();
        
        return $this->render('auction/index.html.twig', [
            'auctions' => $auctions,
        ]);
    }
    
    /*
     * Wyświetlanie szczegółów aukcji
     */
    public function detailsAction(Auction $auction) {
        
        return $this->render('auction/details.html.twig', [
            'auction' => $auction]);
    }
    
    /*
     * Formularz dodawania aukcji
     */
    public function addAction(Request $request) {
        
        $auction = new Auction();
        
        /*
         * Stworzenie formularza
         */
        $form = $this->createForm(AuctionType::class, $auction);
        
        /*
         * Przetworzenie danych z formularza
         * i przekierowanie do widoku aukcji
         */
        if ($request->isMethod('post')){
            
            $form->handleRequest($request);
            
            $auction
                    ->setStatus(Auction::STATUS_ACTIVE);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($auction);
            $entityManager->flush();
            
            return $this->redirectToRoute('auction_details', ['id' => $auction->getId()]);
        }
        
        /*
         * Wyswietlenie formularza
         */
        return $this->render('auction/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    /*
     * Formularz edycji aukcji
     */
    public function editAction(Request $request, Auction $auction) {
        
        /*
         * Stworzenie formularza
         */
        $form = $this->createForm(AuctionType::class, $auction);
        
        /*
         * Przetworzenie danych z formularza
         * i przekierowanie do widoku aukcji
         */
        if ($request->isMethod('post')) {
            $form->handleRequest($request);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($auction);
            $entityManager->flush();
            
            return $this->redirectToRoute('auction_details', ['id' => $auction->getId()]);
        }
        
        /*
         * Wyswietlenie formularza
         */
        return $this->render('auction/edit.html.twig', ['form' => $form->createView()]);
        
    }
}
