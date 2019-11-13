<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $update_at;
    
    /**
     * @ORM\ManyToOne(targetEntity="Auction", inversedBy="offers")
     * @ORM\JoinColumn(name="auction_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $auction;




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
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTimeInterface $update_at): self
    {
        $this->update_at = $update_at;

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
}
