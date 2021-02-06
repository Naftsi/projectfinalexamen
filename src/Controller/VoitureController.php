<?php
namespace App\Controller;
use App\Form\VoitureType ;
use App\Entity\Voiture ;
use App\Form\AgenceType ;
use App\Entity\Agence ;
use App\Form\ClientType ;
use App\Entity\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route ;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;


class VoitureController extends AbstractController 
{
      /**
     * @Route("/affichervoiture" , name="affichervoiture")
     */
    public function afficher():Response
    {
        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findAll();
        return $this->render ('affichervoiture.html.twig' ,[
            'voitures' => $voitures,
        ]);
    }
    /**
     * @Route("/voiture" , name="voiture")
     */
    public function index():Response
    {
        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findAll();
        return $this->render ('index.html.twig' ,[
            'voitures' => $voitures,
        ]);
    }
    /**
     * @Route("/ajouter" , name="ajoutervoiture")
     */
    public function AjouterVoiture (Request $request):Response
    {
        $voiture= new Voiture();
        $form= $this->createForm(VoitureType::class, $voiture);
        $form -> handleRequest($request);
        if($form->isSubmitted()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager ->persist($voiture);
            $entityManager ->flush();
            return $this-> redirectToRoute('voiture') ;

        }
        return $this->render('ajouter.html.twig',[
        'form'=> $form->createView()
        ]);
    }
    /**
     *@Route("/modifier/{mat}" , name="modifiervoiture")
     */
    public function modifier (String $mat , Request $request ):Response
    {
        
        $voitures =$this->getDoctrine()->getRepository(Voiture::class)->findBy(array('matricule' => $mat));
        if(!$voitures){
        throw $this->createNotFoundException('pas de voiture avec la matricule'.$mat);}
        $voiture=$voitures[0];
        $form= $this->createForm(VoitureType::class , $voiture);
        $form->handleRequest($request);
        if( $form->isSubmitted()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($voiture);
            $entityManager->flush();
            return $this->redirectToRoute('voiture');
        }
        return $this->render('modifier.html.twig',[
            'form'=>$form->createView()
        ]);

    }
    /**
     *@Route("/supprimer/{mat}" , name="supprimervoiture") 
     */
    public function supprimer (String $mat):Response {
        $entityManager = $this->getDoctrine()->getManager();
        $voiture=$this->getDoctrine()->getRepository(Voiture::class)->findBy(array ('matricule' => $mat));
        if(!$voiture){
        throw  $this->createNotFoundException(' pas de voiture avec la matricule '.$mat);
        }
        $entityManager->remove($voiture[0]);
        $entityManager->flush();
        $this->addFlash('notice' , 'voiture supprimé');
        return $this->redirectToRoute('voiture');
    }
  
     /**
     * @Route("/louervoiture/{mat}", name="louervoiture")
     */   
    public function louervoiture (String $mat , Request $request): Response
    {   
        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findBy(array ('matricule' => $mat));
        $voiture= $voitures[0];
        $form = $this-> createForm(VoitureType::class ,$voiture);
        $voiture->setDisponibilite(1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($voiture);
            $entityManager->flush();
            return $this->redirectToRoute('affichervoiture');       
    }
     /**
     * @Route("/rendrevoiture/{mat}", name="rendrevoiture")
     */   
    public function rendrevoiture (String $mat , Request $request): Response
    { 
        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findBy(array ('matricule' => $mat));
        $voiture= $voitures[0];
        $form = $this-> createForm(VoitureType::class ,$voiture);
        $voiture->setDisponibilite(0);   
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($voiture);
        $entityManager->flush();
        return $this->redirectToRoute('affichervoiture');    
    }
    /**
     *@Route("/calculevoiture" ,name="calculvoiture" ) 
     */
    public function calculer():Response
    {
      $voitures=$this->getDoctrine()->getRepository(Voiture::class)->findAll();
      return $this->render('afficherstatistique.html.twig' ,[
             'voitures' => $voitures
      ]);
    }
}

?>