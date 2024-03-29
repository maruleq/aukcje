<?php

namespace App\Command;

use App\Entity\Auction;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\EventDispatcher\AuctionEvent;
use App\EventDispatcher\Events;

class ExpireAuctionCommand extends Command {

    /*
     * Wywołanie komendy:
     * bin/console app:expire_auction
     */
    
    /**
     *
     * @var EntityManager
     */
    private $entityManager;
    
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(EntityManagerInterface $entityManager, EventDispatcherInterface $eventDispatcher) {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }
    


    /**
     * {@inheritdoc}
     */
    protected function configure() {

        $this
            ->setName("app:expire_auction")
            ->setDescription("Komenda do wygaszania aukcji");
    }
    
    public function execute(InputInterface $input, OutputInterface $output) {

        $auctions = $this->entityManager->getRepository(Auction::class)->findActiveExpired();
        $output->writeln(sprintf("Ilość aukcji do wygaszenia <info>%d</info> ", count($auctions)));

        foreach ($auctions as $auction) {
            $auction->setStatus(Auction::STATUS_FINISHED);
            $this->entityManager->persist($auction); 
            
            $this->eventDispatcher->dispatch(Events::AUCTION_EXPIRE, new AuctionEvent($auction));
        }

        $this->entityManager->flush();

        $output->writeln("Aktualizacja aukcji powiodła się!");
    }

}
