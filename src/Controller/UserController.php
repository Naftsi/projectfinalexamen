<?php
namespace App\Controller ;
use App\Form\RegistrationFormType ;
use App\Entity\User ;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route ;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController{

/**
      *@Route("/afficheragent" , name="afficheragent") 
      */
      public function afficher():Response 
      {
          $users=$this->getDoctrine()->getRepository(User::class)->findAll();
          return $this->render('afficheruser.html.twig',[
              'users'=>$users
          ]);
      }
      /**
       *@Route("/ajouteragent" , name="ajouteragent") 
       */
      public function ajouter(Request $request ,UserPasswordEncoderInterface $passwordEncoder): Response 
      {
         $user = new User();
         $form=$this->CreateForm(RegistrationFormType::class, $user);
         $form->handleRequest($request);

         if($form->isSubmitted()){
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($user);
             $entityManager->flush();
          return  $this->redirectToRoute('afficheragent');
         }
         return $this->render('ajouteragent.html.twig',[
             'form' => $form->createView()
         ]);
      }
       /**
     *@Route("/supprimeragent/{email}" , name="supprimeragent") 
     */
    public function supprimercontrat(String $email)
    {   $entityManager = $this->getDoctrine()->getManager();
        $user =$this->getDoctrine()->getRepository(User::class)->findBy(array ( 'email'=> $email));
        if(!$user){
        throw $this->createNotFoundExpection('ya pas un agent d email'.$email);}
        $entityManager->remove($user[0]);
        $entityManager->flush();
        $this->addFlash('notice' , 'agent supprimé');
    
        return $this->redirectToRoute('afficheragent');
        
    }
    /**
     *@Route("/modifieragent/{email}" , name="modifieragent")
     */
    public function modifier (String $email , Request $request ):Response
    {
        
        $users =$this->getDoctrine()->getRepository(User::class)->findBy(array('email' => $email));
        if(!$users){
        throw $this->createNotFoundException('pas de  user avec lemail'.$email);}
        $user=$users[0];
        $form= $this->createForm(RegistrationFormType::class , $user);
        $form->handleRequest($request);
        if( $form->isSubmitted()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('afficheragent');
        }
        return $this->render('modifieragent.html.twig',[
            'form'=>$form->createView()
        ]);

    }
}
?>