<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;
use App\Entity\Article;
use App\Entity\Comment;


class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker= \Faker\Factory::create();

        for ($i=1; $i<= 3 ; $i++) { 
        	$category= new Category();

        	$category->setTitle($faker->domainWord);
        	   
        	 $manager->persist($category);
        	for ($j=1; $j <=mt_rand(4,7) ; $j++) { 

        		$content='<p>' . join($faker->paragraphs(2),'</p><p>') . '</p>';
        		 
        		 $article= new Article();
        		 $article->setTitle($faker->domainWord)
        		         ->setContent($content)
        		         ->setImage($faker->imageUrl($width = 300, $height = 100))
        		         ->setCreatedAt($faker->dateTimeBetween('-6months'))
        		         ->setCategory($category);

        		   $manager->persist($article);

        		for ($k=1; $k <mt_rand(6,10) ; $k++) {
        			$content='<p>' . join($faker->paragraphs(2),'</p><p>') . '</p>';

        			$now= new \DateTime();
                    $interval= $now->diff($article->getCreatedAt());
                    $days= $interval->days;
                    $minimum= '-' .$days.' days';
        		 
        		   	$comment= new Comment();
        		   	$comment->setAuthor($faker->name)
        		   	        ->setContent($content)
        		   	        ->setCreatedAt($faker->dateTimeBetween($minimum))
        		   	        ->setArticle($article);

        		   	    $manager->persist($comment);



        		   }   

        	}
        	         

        }


        $manager->flush();
    }
}
