<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="registration")

     
     */
    public function registration(Request $request,ObjectManager $manager,UserPasswordEncoderInterface $encoder)
    {
      
            $user=new User();
            

    	$form=$this->createForm(RegistrationType::class,$user);
    	$form->handleRequest($request);

    	if ($form->isSubmitted() && $form->isValid()) {

    		  $hash= $encoder->encodePassword($user,$user->getPassword());
    		  $user->setPassword($hash);
    		
    		  $manager->persist($user);
    		  $manager->flush();
    		
    	 return $this->redirectToRoute('connexion');
    	}

    	return $this->render('security/registration.html.twig',[

          'form'=> $form->createView()
         
    	]);
    }

     /**
     * @Route("/connexion", name="connexion")
     */

     public function login(){

     	return $this->render('security/welcome.html.twig');
     }
   
   /**
   * @Route("/deconnexion", name="deconnexion")
   */

   public function logout(){}
}
