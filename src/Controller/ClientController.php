<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ClientType;
use App\Entity\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

Class ClientController extends AbstractController
{


/**
 * @Route("/ajouterclient" , name="ajouterclient")
 */
public function Ajouterclient (Request $request):Response
{
    $client= new Client();
    $form =$this->createform(ClientType::class,$client);
    $form->handleRequest($request);
    if($form->isSubmitted())
    {
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->persist($client);
        $entityManager->flush();
        return $this->redirectToRoute('client');
    }

    return $this->render('ajouterclient.html.twig', [
        'form'=>$form->createView()
    ]);
}   

/**
 * @Route("/client" , name="client")
 */
public function Afficheclient ():Response
{
    $Clients=$this->getDoctrine()->getRepository(Client::class)->findAll();
    return $this->render('indexclient.html.twig' , [
        'Clients' => $Clients
    ]);
}

  /**
     * @Route("/supprimerclient/{n_permis}" , name="supprimerclient")
     */   
    public function supprimeragence (String $n_permis): Response
    {   $entityManager = $this->getDoctrine()->getManager();
        $Client = $this->getDoctrine()->getRepository(Client::class)->findBy(array('n_permis'=> $n_permis));
        if(!$Client){
            throw $this->createNotFoundException('pas de client avec le n_permis'  .$n_permis);}
    
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($Client[0]);
                $entityManager->flush();
                $this->addFlash('notice' , 'client supprimé');
                return $this->redirectToRoute('client');
    }

    /**
     * @Route("/modifierclient/{n_permis}", name="modifierclient")
     */   
    public function modifieeraence(String $n_permis , Request $request): Response
    {   $entityManager = $this->getDoctrine()->getManager();
        $clients = $this->getDoctrine()->getRepository(Client::class)->findBy(array('n_permis'=> $n_permis));
        if(!$clients){
            throw $this->createNotFoundException('pas de agance avec le tel'  .$n_permis);}
            $client= $clients[0];
            $form = $this-> createForm(ClientType::class ,$client);
            $form ->handleRequest($request);
            if($form->isSubmitted()){
              
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($client);
                $entityManager->flush();
                return $this->redirectToRoute('client');}
                return $this->render('modifierclient.html.twig', 
                [ 'form'  =>$form->createView()]);
   
    }

}
?>