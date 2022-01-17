<?php

namespace App\Entity\Tests;
use App\Entity\Category;

use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testTrue(): void
    {
        $category = new Category;
        $category->setLabel('Manga');
        $this->assertTrue($category->getLabel() === 'Manga');
    }

    public function testFalse(): void
    {
        $category = new Category;
        $category->setLabel('Manga');
        $this->assertFalse($category->getLabel() !== 'Manga');
    }

    public function testEmpty(): void
    {
        $category = new Category;           
        $this->assertEmpty($category->getLabel());
    }
}
