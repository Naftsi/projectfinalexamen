<?php
namespace App\Controller ;

use App\Form\FactureType ;
use App\Entity\Facture ;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route ;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FactureController extends AbstractController{
     /**
      *@Route("/afficherfacture" , name="afficherfacture") 
      */
      public function afficher():Response 
      {
          $factures=$this->getDoctrine()->getRepository(Facture::class)->findAll();
          return $this->render('indexfacture.html.twig',[
              'factures'=>$factures
          ]);
      }
      /**
       *@Route("/ajouterfacture" , name="ajouterfacture") 
       */
      public function ajouter(Request $request):Response
      {   
          $facture= new Facture ();
          $form=$this->createForm(FactureType::class, $facture);
          $form->handleRequest($request);
          if($form->isSubmitted()){
              $entityManager=$this->getDoctrine()->getManager();
              $entityManager->persist($facture);
              $entityManager->flush();
            return $this->redirectToRoute('afficherfacture');
          }
          return $this->render('ajouterfacture.html.twig' ,[
              'form'=> $form->createView()
          ]) ;
      }
   /**
    *@Route("/payer/{montant}" ,name="payer") 
    */
   public function payerfacture (int $montant , Request $request):Response
   {
         $factures = $this->getDoctrine()->getRepository(Facture::class)->findBy(array('montant' => $montant));
         $facture = $factures[0];
         $form=$this->createForm(FactureType::class,$facture);

         $facture->setPayee(1);
         $entityManager=$this->getDoctrine()->getManager();
         $entityManager->persist($facture);
         $entityManager->flush();
         return $this->redirectToRoute('afficherfacture');

   }
   /**
    *@Route("/calculefacture") 
    */
 public function calculerfacture():Response
 {
     $factures=$this->getDoctrine()->getRepository(Facture::class)->findAll();
     return $this->render('calculfacture.html.twig',[
         'factures'=> $factures
     ]);
 }
     
}



?>