<?php

namespace App\Tests;

use Monolog\Test\TestCase;

class ClassTest  extends TestCase
{

    public function noteStagiaires():void
    {
        $this->assertEquals(100, 10*10);
    }
}