<?php

namespace App\Menu;
 
use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Description of Builder
 *
 * @author marek
 */
class Builder {
    
     private $factory; 
 
    /** 
     * @param FactoryInterface $factory 
     */ 
    public function __construct(FactoryInterface $factory)
    { 
        $this->factory = $factory;
    } 
 
    public function AuthenticatedMenu(RequestStack $requestStack)
    { 
        $menu = $this->factory->createItem('root'); 
 
        $menu->addChild('Aukcje', ['route' => 'auction_index']); 
        $menu->addChild('Dodaj aukcję', ['route' => 'my_auction_add']);
        $menu->addChild('Moje aukcje', ['route' => 'my_auction_index']);
        $menu->addChild('Mój profil', ['route' => 'fos_user_profile_show']);
        $menu->addChild('Wyloguj się', ['route' => 'fos_user_security_logout']);
        
 
        return $menu;
    }
    
    public function AnonymousMenu(RequestStack $requestStack)
    { 
        $menu = $this->factory->createItem('root'); 
 
        $menu->addChild('Aukcje', ['route' => 'auction_index']); 
        $menu->addChild('Zaloguj się', ['route' => 'fos_user_security_login']);
        $menu->addChild('Zarejestruj się', ['route' => 'fos_user_registration_register']);
        
 
        return $menu;
    }
}
