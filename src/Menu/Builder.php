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
 
        $menu->addChild('Aukcje', ['route' => 'auction_index'])
                ->setLinkAttribute('class', 'nav-link'); 
        $menu->addChild('Dodaj aukcję', ['route' => 'my_auction_add'])
                ->setLinkAttribute('class', 'nav-link');
        $menu->addChild('Moje aukcje', ['route' => 'my_auction_index'])
                ->setLinkAttribute('class', 'nav-link');
        $menu->addChild('Mój profil', ['route' => 'fos_user_profile_show'])
                ->setLinkAttribute('class', 'nav-link');
        $menu->addChild('Wyloguj się', ['route' => 'fos_user_security_logout'])
                ->setLinkAttribute('class', 'nav-link');
        
 
        return $menu;
    }
    
    public function AnonymousMenu(RequestStack $requestStack)
    { 
        $menu = $this->factory->createItem('root'); 
 
        $menu->addChild('Aukcje', ['route' => 'auction_index'])
                ->setLinkAttribute('class', 'nav-link');
        $menu->addChild('Zaloguj się', ['route' => 'fos_user_security_login'])
                ->setLinkAttribute('class', 'nav-link');
        $menu->addChild('Zarejestruj się', ['route' => 'fos_user_registration_register'])
                ->setLinkAttribute('class', 'nav-link');
        
 
        return $menu;
    }
}
