<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Form\ArticleFormType;
use App\Form\CommentFormType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {

    	

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',

        ]);
    }
  
  /**
  * @Route("/blog", name="blog")
  */

   public function home(ArticleRepository $repo){

   	$articles=$repo->findAll();

   	 return $this->render('blog/home.html.twig', [

      'articles'=>$articles

                
   	 ]);
   }

    /**

    *@Route("/blog/new",name="blog_create")

    *@Route("/blog/{id}/edit", name="blog_edit")

    */
   public function form(Article $article=null, Request $request, ObjectManager $manager){

        if(!$article){

        	$article=new Article();
        }

        $form=$this->createForm(ArticleFormType::class ,$article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        	
        	  if (!$article->getId()) {
        	  	
        	  	   $article->setCreatedAt(new \DateTime());
        	  }

        	  $manager->persist($article);
        	  $manager->flush();
        	  return $this->redirectToRoute('blog_show',[
                 
                 'id'=>$article->getId(),
                 
                
        	  ]);
        }

   	 return $this->render('blog/create.html.twig',[
     
         'article'=> $form->createView(),
         'editMode'=> $article->getId()!==null
   	 ]);
   }

    /**
    * @Route("/blog/{id}",name="blog_show")
    */
      
   public function show(Article $article,Request $request,ObjectManager $manager ){
            
            $comment=new Comment();
            $form=$this->createForm(CommentFormType::class,$comment);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
              
                   $comment->setCreatedAt(new \DateTime())
                           ->setArticle($article);
                   $manager->persist($comment);
                   $manager->flush();

              return $this->redirectToRoute('blog_show', [
     
                    'id'=>$article->getId()

              ]);

            }
         
        return $this->render('blog/show.html.twig',[
          
          'article'=> $article,
          'CommentForm'=>$form->createView()



 
       ]);

   }

    
}
