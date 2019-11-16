<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;

/**
 * Szczegóły DateExtension
 *
 * @author Marek Grabowski
 */
class DateExtension extends AbstractExtension {
    
    /**
     * 
     * @return array
     */
    public function getFilters() {
        
        return [ new \Twig_SimpleFilter("expireDate", [$this, "expireDate"]) ];
    }
    
    /**
     * 
     * @return array
     */
    public function getFunctions() {
        
        return [ new \Twig_SimpleFunction("auctionStyle", [$this, "auctionStyle"])];
    }
    
    /**
     * @param \DateTime $expiresAt
     * 
     * @return string
     */
    public function expireDate(\DateTime $expiresAt) {
        
        if ($expiresAt <= new \DateTime()) {
            return "Aukcja dobiegła końca";
        }
        
        if ($expiresAt < new \DateTime("+1 day")) {
            return "za " . $expiresAt->format("H") . " godz. " . $expiresAt->format("i") . " min.";
        }   
        
        if ($expiresAt > new \DateTime("+7 days")) {
            return $expiresAt->format("Y-m-d H:i");
        }
        
        if ($expiresAt > new \DateTime("+1 day")) {
            return " za " . $expiresAt->diff(new \DateTime())->days . " dni";
        }
    }
    
    /**
     * @param \DateTime $expiresAt
     * 
     * @return string
     */
    public function auctionStyle(\DateTime $expiresAt) {
        
        if ($expiresAt < new \DateTime()) {
            return "card-header bg-success";
        } elseif ($expiresAt <= new \DateTime("+1 day")) {
            return "card-header bg-warning";
        }
        
        return"card-header bg-info";
    }
}
