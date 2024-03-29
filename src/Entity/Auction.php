<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *  Auction
 *
 * @ORM\Table(name="auction")
 * @ORM\Entity(repositoryClass="App\Repository\AuctionRepository")
 */
class Auction
{
    const STATUS_ACTIVE = "active";
    const STATUS_FINISHED = "finished";
    const STATUS_CANCELLED = "cancelled";
    
    /**
     * @var int
     * 
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string
     * 
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank(
     *      message="Pole nie może być puste"
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "Minimalna ilosć znaków to 3",
     *      maxMessage = "Maksymalna ilosć znaków to 255"
     * )
     */
    private $title;

    /**
     * @var string
     * 
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank(
     *      message="Pole nie może być puste"
     * )
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Minimalna ilosć znaków to 10",
     * )
     */
    private $description;

    /**
     * @var float
     * 
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     * @Assert\NotBlank(
     *      message="Pole nie może być puste"
     * )
     * @Assert\GreaterThan(
     *      value="0",
     *      message="Cena musi być większa od 0"
     * )
     */
    private $price;
    
    /**
     * @var float
     *
     * @ORM\Column(name="starting_price", type="decimal", precision=10, scale=2)
     * @Assert\NotBlank(
     *      message="Pole nie może być puste"
     * )
     * @Assert\GreaterThan(
     *      value= "0",
     *      message="Cena wywoławcza musi być większa od 0"
     * )
     */
    private $startingPrice;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;
    
     /**
     * @var \DateTime
     *
     * @ORM\Column(name="expires_at", type="datetime")
     * @Assert\NotBlank(
     *      message="Musisz podać datę zakończenia aukcji"
     * )
     * @Assert\GreaterThan(
      *     value="+1 day",
     *      message="Aukcja nie może kończyć się za mniej niż 24 godziny"
     * )
     */
    private $expiresAt;
    
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=10)
     */
    private $status;
    
    /**
     * @var Offer[]
     * 
     * @ORM\OneToMany(targetEntity="Offer", mappedBy="auction")
     */
    private $offers;
    
    /**
     *
     * @var User
     * 
     * @ORM\ManyToOne(targetEntity="User", inversedBy="auctions")
     */
    private $owner;
    
    /**
     * Auction constructor
     */
    public function _construct() {
        $this->offers = new ArrayCollection();
    }





    /* Getters and Setters */
    
    
    
    
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Auction
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Auction
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get price.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price.
     *
     * @param string $price
     *
     * @return Auction
     */
    public function setPrice(string $price)
    {
        $this->price = $price;

        return $this;
    }
    
    /**
     * Get startingPrice.
     *
     * @return float
     */
    public function getStartingPrice()
    {
        return $this->startingPrice;
    }
    
    /**
     * Set startingPrice.
     *
     * @param float $startingPrice
     *
     * @return Auction
     */
    public function setStartingPrice($startingPrice)
    {
        $this->startingPrice = $startingPrice;

        return $this;
    }
    
     /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    
    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    
    /**
     * Get expiresAt.
     *
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }
    
    /**
     * Set expiresAt.
     *
     * @param \DateTime $expiresAt
     *
     * @return $this
     */
    public function setExpiresAt(\DateTime $expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }
    
    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Set status.
     *
     * @param string $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
    
    /**
     * @param Offer $offer
     * 
     * @return $this
     */
    public function addOffer(Offer $offer) {
        
        $this->offers[] = $offer;
        
        return $this;
    }
    
    /**
     * @return Offer[]|ArrayCollection
     */
    public function getOffers() {
        
        return $this->offers;
    }
    
     /**
     * 
     * @param User $owner
     * 
     * @return $this
     */
    public function setOwner(User $owner) {
        
        $this->owner = $owner;
        
        return $this;
    }
    
    /**
     * 
     * @return User
     */
    public function getOwner() {
        
        return $this->owner;
    }
}
