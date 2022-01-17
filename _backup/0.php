<?php

namespace App\Tests\Entity;

use App\Entity\Author;
use PHPUnit\Framework\TestCase;


class AuthorTest extends TestCase
{
    public function testTrue(): void
    {       
        $author = new Author;
        $author->setFirstname("Ange");
        $author->setLastname("PLANITEYE");      
        $author->setEmail("bplaniteye@gmail.com");
        $author->setPassword("123456");
        $this->assertTrue($author->getFirstname() === "Ange");
        $this->assertTrue($author->getLastname() === "PLANITEYE");       
        $this->assertTrue($author->getEmail() === "bplaniteye@gmail.com");
        $this->assertTrue($author->getPassword() === "123456");      
    }

    public function testFalse(): void
    {
        $author = new Author; 
        $author->setFirstname("Ange");
        $author->setLastname("PLANITEYE");
        $author->setEmail("bplaniteye@gmail.com");
        $author->setPassword("123456");    
        $this->assertFalse($author->getFirstname() !== "Ange");
        $this->assertFalse($author->getLastname() !== "PLANITEYE");    
        $this->assertFalse($author->getEmail() !== "bplaniteye@gmail.com");
        $this->assertFalse($author->getPassword() !== "123456");
        $this->assertFalse($author->getAddress() !== "1 rue Crevoulin 77000 Melun");
      
    }

    public function testEmpty(): void
    {
        $author = new Author;
        $this->assertEmpty($author->getFirstname());
        $this->assertEmpty($author->getLastname());       
        $this->assertEmpty($author->getEmail());
        $this->assertEmpty($author->getPassword());
        $this->assertEmpty($author->getRoles());
    }
}
