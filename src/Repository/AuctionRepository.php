<?php

namespace App\Repository;

use App\Entity\Auction;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Auction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Auction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Auction[]    findAll()
 * @method Auction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuctionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Auction::class);
    }
    
    /**
     * @return Auction[]
     */
    public function findActiveOrdered()
    {
        return $this->createQueryBuilder("a")
            ->where("a.status = :active")
            ->setParameter("active", Auction::STATUS_ACTIVE)
            ->andWhere("a.expiresAt > :now")
            ->setParameter("now", new \DateTime())
            ->orderBy("a.expiresAt", "ASC")
            ->getQuery()
            ->getResult();
    }
    
     /**
     * @param User $owner
     *
     * @return Auction[]
     */
    public function findMyOrdered(User $owner)
    {
        return $this
            ->getEntityManager()
            ->createQuery(
                "SELECT a
                FROM App:Auction a
                WHERE a.owner = :owner
                ORDER BY a.expiresAt ASC"
            )
            ->setParameter("owner", $owner)
            ->getResult();
    }

    // /**
    //  * @return Auction[] Returns an array of Auction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Auction
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
