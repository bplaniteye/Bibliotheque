<?php

namespace App\Tests\Entity;

use App\Entity\Article;
use App\Entity\Comment;
use DateTime;

use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    public function testTrue(): void
    {       
        $dateTime = New DateTime();        
        $article = new Article();
                    
        $comment = new Comment;
        $comment->setContent('contenu')                             
                 ->setDatetime($dateTime)
                 ->setArticle($article);        
        $this->assertTrue($article->getContent() === 'contenu');  
        $this->assertTrue($article->getTitle() === $dateTime);          
        $this->assertTrue($article->getArticle() === $article);
    }

    public function testFalse(): void
    {       
        $dateTime = New DateTime();        
        $article = new Article();
                    
        $comment = new Comment;
        $comment->setContent('contenu')                             
                 ->setDatetime($dateTime)
                 ->setArticle($article);        
        $this->assertFalse($article->getContent() !== 'contenu');  
        $this->assertFalse($article->getTitle() !== $dateTime);          
        $this->assertFalse($article->getArticle() !== $article);
    }


public function testEmpty(): void
{         
    $article = new Article();
                
    $comment = new Comment;         
    $this->assertEmpty($article->getContent());  
    $this->assertEmpty($article->getTitle());          
    $this->assertEmpty($article->getArticle());
}

   /* public function AddGetRemoveCommentaires(){
        
        $articles = new Articles();
        $commentaire = new Commentaires();

        $this->assertEmpty($articles->getArtcileComm());

        $articles->addCommentaire($commentaire);
        $this->assertContains($commentaire, $articles->getArtcileComm());

        $articles->RemoveCommentaire($commentaire);
        $this->assertEmpty($articles->getArtcileComm());
    }*/

    //    public function AddCommentaires(){
        
    //     $articles = new Articles();
    //     $commentaire = new Commentaires();

    //     $this->assertEmpty($articles->getCommentaire());

    //     $articles->addCommentaire($commentaire);
    //     $this->assertContains($commentaire, $articles->getCommentaire());

    //     $articles->RemoveCommentaire($commentaire);
    //     $this->assertEmpty($articles->getCommentaire());

    // }
}