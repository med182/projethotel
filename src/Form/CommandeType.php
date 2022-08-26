<?php

namespace App\Form;

use App\Entity\Chambre;
use App\Entity\Commande;
use App\Entity\User;
use DateTimeImmutable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{

    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startAt', DateTimeType::class,[
                'widget'=>'single_text',
                'label'=>'Début' 
            ])
            ->add('endAT', DateTimeType::class,[
                'widget'=>'single_text',
                'label'=>'Fin' 
            ])
        
        
            ->add('Chambre', EntityType::class,[
                'class'=>Chambre::class,
                'choice_label'=>function($objet){
                    return $objet->getTitre();
                }
            ])
            ->add('User', EntityType::class, [
                'class'=>User::class,
                'choice_label'=>'email'
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
