<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\ChambreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ChambreRepository $chambreRepository): Response
    {
        $chambres=$chambreRepository->findAll();
        return $this->render('home/index.html.twig',[
            "chambres"=>$chambres
        ]);
    }
    

    
     #[Route('/chambre/{id}', name:'chambre')]
    
    public function chambre(Chambre $chambre, Request $request, EntityManagerInterface $manager)
    {
        $commande = new Commande;

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $user = $this->getUser();

            $commande->setUser($user);
            $commande->setChambre($chambre);
            
            $start = $commande->getStartAt();
            $end = $commande->getEndAt();

            $diff = $start->diff($end);

            $days = $diff->days;

            $resultat = round( $days * $chambre->getPrix() ,2);

            $commande->setPrix($resultat);
    



            $commande->setCreatedAt(new \DateTimeImmutable("now"));
           

            $manager->persist($commande);
            $manager->flush();

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render("home/chambre.html.twig", [
            "chambre" => $chambre,
            "form" => $form->createView()
        ]);
  
}
}
