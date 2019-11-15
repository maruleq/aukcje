<?php

/*
 * Aplikacja Aukcje została zbudowana podczas kursu
 * Symphony 3 na strefakursow.pl i następnie dostosowana do Symfony 4
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\BidType;
use App\Form\AuctionType;
use App\Entity\Auction;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
        $auctions = $entityManager->getRepository(Auction::class)->findBy(['status' => Auction::STATUS_ACTIVE]);
        
        return $this->render('auction/index.html.twig', [
            'auctions' => $auctions,
        ]);
    }
    
    /*
     * Wyświetlanie szczegółów aukcji
     */
    public function detailsAction(Auction $auction) {
        
        if ($auction->getStatus() === Auction::STATUS_FINISHED) {

            return $this->render('auction/finished.html.twig', ['auction' => $auction]);
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
        
        return $this->render('auction/details.html.twig', [
            'auction' => $auction,
            'deleteForm' => $deleteForm->createView(),
            'finishForm' => $finishForm->createView(),
            'buyForm' => $buyForm->createView(),
            'bidForm' => $bidForm->createView()
        ]);
    }
    
    /*
     * Formularz dodawania aukcji
     */
    public function addAction(Request $request) {
        
        $this->denyAccessUnlessGranted("ROLE_USER");
        
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
            
            if ($auction->getStartingPrice() >= $auction->getPrice()) {
                $form->get("startingPrice")->addError(new FormError("Cena wywoławcza nie może być wyższa od ceny kup teraz"));
            }
            
            if ($form->isValid()) {
                $auction
                        ->setStatus(Auction::STATUS_ACTIVE)
                        ->setOwner($this->getUser());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($auction);
                $entityManager->flush();
            
                $this->addFlash("success", "Aukcja {$auction->getTitle()} została dodana");
            
                return $this->redirectToRoute('auction_details', ['id' => $auction->getId()]);
            }
            
            $this->addFlash("error", "Nie udało się dodać aukcji!");
        }
        
        /*
         * Wyświetlenie formularza
         */
        return $this->render('auction/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    /*
     * Formularz edycji aukcji
     */
    public function editAction(Request $request, Auction $auction) {
        
        $this->denyAccessUnlessGranted("ROLE_USER");
        
        if ($this->getUser() !== $auction->getOwner()) {
            throw new AccessDeniedException();
        }
        
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
            
            $this->addFlash("success", "Aukcja {$auction->getTitle()} została zaktualizowana");
            
            return $this->redirectToRoute('auction_details', ['id' => $auction->getId()]);
        }
        
        /*
         * Wyświetlenie formularza
         */
        return $this->render('auction/edit.html.twig', ['form' => $form->createView()]);
        
    }
    
    /*
     * Usuwanie aukcji
     */
    public function deleteAction(Auction $auction) {
        
        $this->denyAccessUnlessGranted("ROLE_USER");
        
        if ($this->getUser() !== $auction->getOwner()) {
            throw new AccessDeniedException();
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($auction);
        $entityManager->flush();
        
        $this->addFlash("success", "Aukcja {$auction->getTitle()} została usunięta");
        
        return $this->redirectToRoute('auction_index');
    }
    
    /*
     * Zakończenie aukcji
     */
    public function finishAction(Auction $auction) {
        
        $this->denyAccessUnlessGranted("ROLE_USER");
        
        if ($this->getUser() !== $auction->getOwner()) {
            throw new AccessDeniedException();
        }
        
        /*
         * Ustawienie aktualnej daty jako zakończenia aukcji
         * Ustawienie statusu aukcji
         */
        $auction
               ->setExpiresAt(new \DateTime())
               ->setStatus(Auction::STATUS_FINISHED);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($auction);
        $entityManager->flush();
        
        $this->addFlash("success", "Aukcja {$auction->getTitle()} została zakończona");
        
        return $this->redirectToRoute('auction_details', ['id' => $auction->getId()]);
    }
}
