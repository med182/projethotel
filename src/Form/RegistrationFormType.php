<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   
        if($options['email']){
        $builder
        ->add('email');
    }
       if($options['terms']){
        $builder
        ->add('agreeTerms', CheckboxType::class, [
            'mapped' => false,
            'constraints' => [
                new IsTrue([
                    'message' => 'You should agree to our terms.',
                ]),
            ],
        ]);
       }
       if($options['nom']){
        $builder
        ->add('nom');
       }
       if($options['prenom']){
        $builder
        ->add('prenom',TextType::class);
       }

       if($options['sexe']){
        $builder
        ->add('sexe',ChoiceType::class,[
            'required'=>false,
            'choices'=>[
                'masculin'=>'masculin',
                'féminin'=>'féminin',
            ]
          
            ]);
       }

       if($options['password']){
        $builder
        ->add('plainPassword', PasswordType::class, [
            // instead of being set onto the object directly,
            // this is read and encoded in the controller
            'mapped' => false,
            'attr' => ['autocomplete' => 'new-password'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a password',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Your password should be at least {{ limit }} characters',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
        ]);
       }

       if($options['pseudo']){
        $builder
        ->add('pseudo', TextType::class);
       }
      
      

            
        if($options['role'])
        {
            $builder
                ->add("roles", ChoiceType::class, [
                    "required" => false,
                    "choices" => [
                        // key => value
                        // key ==> navigateur
                        // value ==> enregistrer dans la propriété
                        "Admin" => "ROLE_ADMIN",
                    ],
                    "multiple" => true,
                    "expanded" => true
                ])
            ;
        }
        
        if($options['update']){
            $builder
            ->add('oldPassword', PasswordType::class,[
                 'required'=>false,
                 'mapped'=>false,
                 'label'=>'Mot de passe actuel',
                 'attr'=>[
                    'placeholder'=>' Mot de passe actuel',
                    'class'=>'password-field-alone'

                 ],
                 
            ])
            ->add('newPassword', PasswordType::class,[
                'required'=>false,
                'mapped'=>false,
                'label'=>'Nouveau de passe',
                'attr'=>[
                    'placeholder'=>'Nouveau mot de passe',
                    'class'=>'password-field-first'
                ],
            ])
        
             
            ->add('confirmPassword', PasswordType::class,[
                  'required'=>false,
                  'mapped'=>false,
                  'label'=>'Confirmation du nouveau mot de passe',
                  'attr'=>[
                    'placeholder'=>'Confirmation du nouveau mot de passe',
                    'class'=>'password-field-first'
                  ],
                ]);
    }

    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'prenom'=>false,
            'nom'=>false,
            'createdAt'=>false,
            'password'=>false,
            'pseudo'=>false,
            'sexe'=>false,
            'role'=>false,
            'email'=>false,
            'terms'=>false,
            'update'=>false,
        ]);
    }
}
