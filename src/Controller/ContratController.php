<?php
namespace App\Controller;
use App\Form\ClientType ;
use App\Entity\Client ;
use App\Form\ContratType ;
use App\Entity\Contrat ;
use App\Form\VoitureType ;
use App\Entity\Voiture ;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route ;
class ContratController extends AbstractController {
/**
 * @Route("/affichercontrat" , name="affichercontrat")
 */
public function index():Response
{
$contrats= $this->getDoctrine()->getRepository(contrat::class)->findAll();
return $this->render('indexcontrat.html.twig' ,[
    'contrats'=> $contrats
]);
}
/**
 *@Route("/ajoutercontrat" , name="ajoutercontrat") 
 */
public function Ajoutercontrat (Request $request):Response
{
    $contrat = new Contrat();
    $form = $this->createForm(ContratType::class,$contrat);
    $form->handleRequest($request);

    if($form->isSubmitted()){
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($contrat);
        $entityManager->flush();
     return  $this->redirectToRoute('affichercontrat');
    }
    return $this->render('ajoutercontrat.html.twig',[
        'form' => $form->createView()
    ]);

}
    /**
     *@Route("/supprimercontrat/{type}" , name="supprimercontrat") 
     */
    public function supprimercontrat(String $type)
    {   $entityManager = $this->getDoctrine()->getManager();
        $contrat =$this->getDoctrine()->getRepository(Contrat::class)->findBy(array ( 'type'=> $type));
        if(!$contrat){
            throw $this->createNotFoundExpection(' ya pas de contart avec le type: '.$type);
        }
        $entityManager->remove($contrat[0]);
        $entityManager->flush();
        $this->addFlash('notice' , 'contrat supprimé');
    
        return $this->redirectToRoute('affichercontrat');
        
    }
      /**
     *@Route("/modifiercontrat/{type}" , name="modifiercontrat")
     */
    public function modifier (String $type, Request $request ):Response
    {
        
        $contrats =$this->getDoctrine()->getRepository(Contrat::class)->findBy(array('type' => $type));
        if(!$contrats){
        throw $this->createNotFoundException('pas d contrat avec le type :'.$type);}
        $contrat=$contrats[0];
        $form= $this->createForm(ContratType::class , $contrat);
        $form->handleRequest($request);
        if( $form->isSubmitted()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contrat);
            $entityManager->flush();
            return $this->redirectToRoute('affichercontrat');
        }
        return $this->render('modifiercontrat.html.twig',[
            'form'=>$form->createView()
        ]);

    }
}

    

?>