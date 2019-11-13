<?php

/*
 * Aplikacja Aukcje została zbudowana podczas kursu
 * Symphony 3 na strefakursow.pl i następnie dostosowana do Symfony 4
 */

namespace App\Form;

use App\Entity\Auction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Szczegóły AuctionType
 *
 * @author Marek Grabowski
 */
class AuctionType extends AbstractType {
    
    /*
     * Budowanie formularza dodawania aukcji
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
            ->add('title', TextType::class, ['label' => 'Tytuł'])
            ->add('description', TextareaType::class, ['label' => 'Opis'])
            ->add('price', NumberType::class, ['label' => 'Cena'])
            ->add('startingPrice', NumberType::class, ['label' => 'Cena wywoławcza'])
            ->add('expiresAt', DateTimeType::class, ['label' => 'Data zakończenia aukcji'])
            ->add('submit', SubmitType::class, ['label' => 'Zapisz']);
    }
    
    /*
     * Wskazanie domyślenj encji do zapisu wartości w bazie danych
     */
    public function configureOptions(OptionsResolver $resolver) {
        
        $resolver
            ->setDefaults(['data_class' => Auction::class]);
    }
}
