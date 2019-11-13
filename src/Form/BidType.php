<?php

/*
 * Aplikacja Aukcje została zbudowana podczas kursu
 * Symphony 3 na strefakursow.pl i następnie dostosowana do Symfony 4
 */

namespace App\Form;

use App\Entity\Offer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Szczegóły BidType
 *
 * @author Marek Grabowski
 */
class BidType extends AbstractType {
    
    /*
     * Budowanie formularza licytacji
     */
    public function buildForm(FormBuilderInterface $builder, array $option) {
        
        $builder
            ->add('price', NumberType::class, ['label' => 'Cena'])
            ->add('submit', SubmitType::class, ['label' => 'Licytuj']);
    }
    
    /*
     * Wskazanie domyślenj encji do zapisu wartości w bazie danych
     */
    public function configureOptions(OptionsResolver $resolver) {
        
        $resolver
            ->setDefaults(['data_class' => Offer::class]);
    }
}
