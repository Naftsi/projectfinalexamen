<?php
namespace App\Controller;
use App\Form\AgenceType ;
use App\Entity\Agence ;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route ;
class AgenceController extends AbstractController {
/**
 * @Route("/afficheragence" , name="afficheragence")
 */
public function index():Response
{
$agences= $this->getDoctrine()->getRepository(Agence::class)->findAll();
return $this->render('indexagence.html.twig' ,[
    'agences'=> $agences
]);
}
/**
 *@Route("/ajouteragence" , name="ajouteragence") 
 */
public function Ajouteragence (Request $request):Response
{
    $agence = new Agence();
    $form = $this->createForm(AgenceType::class,$agence);
    $form->handleRequest($request);

    if($form->isSubmitted()){
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($agence);
        $entityManager->flush();
return  $this->redirectToRoute('afficheragence');
    }
    return $this->render('ajouteragence.html.twig',[
        'form' => $form->createView()
    ]);

}
    /**
     *@Route("/supprimeragence/{tel_agence}" , name="supprimeragence") 
     */
    public function supprimeragence(String $tel_agence)
    {   $entityManager = $this->getDoctrine()->getManager();
        $agence =$this->getDoctrine()->getRepository(Agence::class)->findBy(array ( 'tel_agence'=> $tel_agence));
        if(!$agence){
            throw $this->createNotFoundExpection(' ya pas d agence avec le num de telephone : '.$tel_agence);
        }
        $entityManager->remove($agence[0]);
        $entityManager->flush();
        $this->addFlash('notice' , 'agence supprimé');
        return $this->redirectToRoute('afficheragence');
        
    }
      /**
     *@Route("/modifieragence/{tel_agence}" , name="modifieragence")
     */
    public function modifier (String $tel_agence , Request $request ):Response
    {
        
        $agences =$this->getDoctrine()->getRepository(Agence::class)->findBy(array('tel_agence' => $tel_agence));
        if(!$agences){
        throw $this->createNotFoundException('pas d agence avec le numero :'.$tel_agence);}
        $agence=$agences[0];
        $form= $this->createForm(AgenceType::class , $agence);
        $form->handleRequest($request);
        if( $form->isSubmitted()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($agence);
            $entityManager->flush();
            return $this->redirectToRoute('afficheragence');
        }
        return $this->render('modifieragence.html.twig',[
            'form'=>$form->createView()
        ]);

    }
}

    

?>