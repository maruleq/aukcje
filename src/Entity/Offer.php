<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Offer
 *
 * @ORM\Table(name="offer")
 * @ORM\Entity(repositoryClass="App\Repository\OfferRepository")
 */
class Offer
{
    const TYPE_BUY = "buy";
    const TYPE_AUCTION = "auction";
    const TYPE_BID = "bid";
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     * @Assert\NotBlank(
     *      message="Cena nie może być pusta"
     * )
     * @Assert\GreaterThan(
     *      value="0",
     *      message="Cena musi być większa od 0"
     * )
     */
    private $price;

    /**
     * @ORM\Column(name="type", type="string", length=10)
     */
    private $type;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="update_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updateAt;
    
    /**
     * @ORM\ManyToOne(targetEntity="Auction", inversedBy="offers")
     * @ORM\JoinColumn(name="auction_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $auction;
    
    /**
     *@var User
     * 
     * @ORM\ManyToOne(targetEntity="User", inversedBy="offers")
     */
    private $owner;




    /* Getters and Setters */
    
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): self
    {
        $this->update_at = $updateAt;

        return $this;
    }
    
    /**
     * @return Auction
     */
    public function getAuction() {
        
        return $this->auction;
    }
    
    /**
     * @param Auction $auction
     * 
     * @return $this
     */
    public function setAuction(Auction $auction) {
        
        $this->auction = $auction;
        
        return $this;
    }
    
    /**
     * 
     * @param User $owner
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
