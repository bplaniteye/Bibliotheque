<?php

namespace App\Tests\Entity;

use App\Entity\Article;
use App\Entity\Author;
use App\Entity\Category;
use App\Entity\Comment;
use DateTime;

use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    public function testTrue(): void
    {
        // $author = new Author();
        $category = new Category();
        $dateTime = new DateTime();
        $article = new Article();

        $article->setTitle('Title')
            ->setSlug('slug')
            ->setContent('contenu')
            ->setCategory($category)
            //->setImageName('Image')
            ->setUpdatedAt($dateTime)
            ->setDatetime($dateTime);
        //->setAuthor($author);

        $this->assertTrue($article->getTitle() === 'Title');
        $this->assertTrue($article->getSlug() === 'slug');
        $this->assertTrue($article->getContent() === 'contenu');
        $this->assertTrue($article->getCategory() === $category);
        $this->assertTrue($article->getDatetime() === $dateTime);
        $this->assertTrue($article->getUpdatedAt() === $dateTime);
        //  $this->assertTrue($articles->getImageName()==='imageName');
        // $this->assertTrue($article->getAuthor()===$author);
    }


    public function testFalse(): void
    {
        // $author = new Author();
        $category = new Category();
        $dateTime = new DateTime();
        $article = new Article();

        $article->setTitle('Title')
            ->setSlug('slug')
            ->setContent('contenu')
            ->setCategory($category)
            ->setUpdatedAt($dateTime)
            ->setDatetime($dateTime);

        //->setAuthor($author);

        $this->assertFalse($article->getTitle() !== 'Title');
        $this->assertFalse($article->getSlug() !== 'slug');
        $this->assertFalse($article->getContent() !== 'contenu');
        $this->assertFalse($article->getCategory() !== $category);
        $this->assertFalse($article->getDatetime() !== $dateTime);
        $this->assertFalse($article->getUpdatedAt() !== $dateTime);
        //  $this->assertTrue($articles->getImageName()==='imageName');
        // $this->assertFalse($article->getAuthor() !== $author);
    }
    public function testEmpty(): void
    {
        $category = new Category();
        $dateTime = new DateTime();
        $article = new Article();

        $this->assertEmpty($article->getId());
        $this->assertEmpty($article->getTitle());
        $this->assertEmpty($article->getSlug());
        $this->assertEmpty($article->getContent());
        $this->assertEmpty($article->getCategory());
        $this->assertEmpty($article->getDatetime());
        //$this->assertEmpty($article->getUpdatedAt());
        //  $this->assertTrue($articles->getImageName()==='imageName');
        // $this->assertEmpty($article->getAuthor() !== $author);
    }

    public function testRelation()
    {
        $article = new Article();
        $comment = new Comment();

        $this->assertEmpty($article->getComment());

        $article->addComment($comment);
        $this->assertContains($comment, $article->getComment());

        $article->RemoveComment($comment);
        $this->assertEmpty($article->getComment());
    }
}
