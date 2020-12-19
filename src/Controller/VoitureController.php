<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Voiture ;
use Doctrine\ORM\EntityManagerInterface ;
use App\Form\VoitureType ;
use Symfony\Component\HttpFoundation\Request;
class VoitureController extends AbstractController
{
       /**
     * @Route("/createvoiture", name="create_voiture")
     */
 
    public function CreateVoiture (Request $request):Response{

        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class,$voiture);
        $form->handleRequest($request);
       
        if($form->isSubmitted()) {
          $voiture = $form->getData();
          $voiture-> setDisponibilite(1);
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($voiture);
          $entityManager->flush();
  
          return $this->redirectToRoute('voiture');
        }
     return $this->render('voiture/ajouter.html.twig',[
            'form' => $form->createView()]);
    }



       
       // $entityManager = $this->getDoctrine()->getManager();

       // $voiture = new Voiture();
       // $voiture ->setMatricule('200U3333');
       // $voiture ->setMarque('BMW');
        //$voiture ->setDescription('Voiture luxe');
        //$voiture ->setCouleur('Noir');
        //$voiture ->setCarburant('gazoil');
        //$date = new \DateTime('2019-06-05 12:15:30');
        //$voiture ->setDatemiseencirculation($date);
        //$voiture ->setDisponibilite(1);
        //$voiture ->setNbrplace(5);
        //$entityManager->persist($voiture);
        //$entityManager->flush();
       // return new Response('Nouvelle voiture ajouté avec la matricule numero ' .$voiture->getMatricule());

          /**
     * @Route("/voiture", name="voiture")
     */   
    public function index(): Response
    {
        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findAll();

        return $this->render('voiture/index.html.twig', [
            'voitures'=> $voitures,
        ]);
    }
      /**
     * @Route("/voiture/{mat}", name="voiturebymat")
     */   
    public function afficher(String $mat): Response
    {
        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findBy(array('matricule'=> $mat));

        return $this->render('voiture/index.html.twig', [
            'voitures'=> $voitures,
        ]);
    }
  /**
     * @Route("/modifiervoiture/{mat}", name="editvoiturebymat")
     */   
    public function modifieer(String $mat , Request $request): Response
    {   $entityManager = $this->getDoctrine()->getManager();
        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findBy(array('matricule'=> $mat));
        if(!$voitures){
            throw $this->createNotFoundException('pas de voiture avec la matricule'  .$mat);}
            $voiture= $voitures[0];
            $form = $this-> createForm(VoitureType::class ,$voiture);
            $form ->handleRequest($request);
            if($form->isSubmitted()){
              
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($voiture);
                $entityManager->flush();
                return $this->redirectToRoute('voiture');}
                return $this->render('voiture/mofifier.html.twig', [ 'form'  =>$form->createView()]);
            

        //$entityManager = $this->getDoctrine()->getManager();
        //$voitures = $this->getDoctrine()->getRepository(Voiture::class)->findBy(array('matricule'=> $mat));
        //if(!$voitures){
           // throw $this->createNotFoundException('pas de voiture avec la matricule'  .$mat);
       // }
        //$voitures[0]-> setMarque('Polo');
        //$entityManager -> flush();
        //return $this->redirectToRoute('voiturebymat', ['mat' => $mat]);
    }
     /**
     * @Route("/supprimervoiture/{mat}", name="supprimervoiturebymat")
     */   
    public function supprimer(String $mat): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findBy(array('matricule'=> $mat));
        if(!$voitures){
            throw $this->createNotFoundException('pas de voiture avec la matricule'  .$mat);
        }
        $entityManager -> remove($voitures[0]);
        $entityManager -> flush();
        return $this->redirectToRoute('voiture');
    }
}
