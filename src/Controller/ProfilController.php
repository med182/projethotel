<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig'
         );
    }

#[Route('/modifier', name:'profil_modification')]

public function profil_modification(Request $request, EntityManagerInterface $manager): Response
{     
    
 $manager;
    return $this->render('profil_modification.html.twig', []);
}



#[Route('/mot-de-pass/modifier', name:'password_modification')]
public function password_modification(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $userPasswordHasherInterface):Response
{
    
    
    $user= $this->getUser();

$form= $this->createForm(RegistrationFormType::class , $user,[
    'update'=>true
]);

$form->handleRequest($request);
    
    if($form->isSubmitted() and $form->isValid()){
        
        
        $oldPassword=$form->get('oldPassword')->getData();
        $newPassword=$form->get('newPassword')->getData();
        $confirmPassword=$form->get('confirmPassword')->getData();
      
$acces=true;
      

        if(!$oldPassword){
            $acces=false;

            $form->get('oldPassword')->addError(new FormError('saisir votre mot de passe actuel'));
        }

        else
        {
        
            if(!$userPasswordHasherInterface->isPasswordValid($user, $oldPassword))
        {
           
            $acces=false;
            $form->get('oldPassword')->addError(new FormError('votre mot de passs actuel est incorrect'));
        }
    
    
        else  {
        if($newPassword !=$confirmPassword){
            $acces=false;
            $form->get('newPassword')->addError(new FormError('les mots de passe ne sont pas identiques'));
        }
        
        else     {
        if(!$newPassword){
            $acces=false;
            $form->get('newPassword')->addError(new FormError('saisir votre mots de passe'));
        }
        
        else{

        if(!$newPassword==$oldPassword){
            $acces=false;
            $form->get('newPassword')->addError(new FormError("il s'agit de votre mot de passe actuel"));
        }

    }

}
        }
    }
       if($acces){
        $user->setPassword($userPasswordHasherInterface->hashPassword(
            $user,
            $newPassword
        ));
          
        $manager->persist($user);
        $manager->flush();
    
        return $this->redirectToRoute('app_profil');


    }
 
    }


    
        





return $this->render('profil/password_modification.html.twig',[
    "form"=>$form->createView()
]);
}
}


 
    
    