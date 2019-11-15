<?php

namespace App\Entity; 

use Doctrine\ORM\Mapping as ORM; 
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
 
/** 
* @ORM\Entity 
* @ORM\Table(name="fos_user")
*/ 
class User extends BaseUser { 
 
    /** 
    * @ORM\Id() 
    * @ORM\GeneratedValue(strategy="AUTO") 
    * @ORM\Column(type="integer") 
    */ 
    protected $id; 

    /**
    *
    * @var Auction[]|ArrayCollection
    * 
    * @ORM\OneToMany(targetEntity="Auction", mappedBy="owner")
    * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", onDelete="CASCADE")
    */
    private $auctions;
    
    /**
     *
     * @var Offer[]|ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Offer", mappedBy="owner")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $offers;
    
    /**
     * User constructor
     */
    public function __construct() {
        parent::__construct();
        $this->auctions = new ArrayCollection();
        $this->offers = new ArrayCollection();
    }
    
    
    
    /* Getters and Setters */
    
    
    
    /**
     * 
     * @return Auction[]|ArrayCollection
     */
    public function getAuctions() {
        
        return $this->auctions;
    }
    
    /**
     * @param Auction $auction
     * 
     * @return $this
     */
    public function addAuction(Auction $auction) {
        
        $this->auctions[] = $auction;
        
        return $this;
    }
    
    /**
     * 
     * @return Offer[]|ArrayCollection
     */
    public function getOffers() {
        
        return $this->offers;
    }
    
    /**
     * 
     * @param Offer $offer
     * 
     * @return $this
     */
    public function addOffer(Offer $offer) {
        
        $this->offers[] = $offer;
        
        return $this;
    }

}
