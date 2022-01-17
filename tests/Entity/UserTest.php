<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;


class UserTest extends TestCase
{
    // public function getUserTest(EntityManagerInterface $manager)
    // {         
    //     $user = new User;
    //     $user->setFirstname("Ange");
    //     $user->setLastname("PLANITEYE");
    //     $user->setBirthday(new \Datetime);
    //     $user->setEmail("bplaniteye@gmail.com");
    //     $user->setPassword("123456");
    //     $user->setAddress("1 rue Crevoulin 77000 Melun");
    //     $manager->persist($user);
    // }

    public function testTrue(): void
    {
        $date = new \Datetime;
        $user = new User;
        $user->setFirstname("Ange");
        $user->setLastname("PLANITEYE");
        $user->setBirthday($date);
        $user->setEmail("bplaniteye@gmail.com");
        $user->setPassword("123456");
        $user->setAddress("1 rue Crevoulin 77000 Melun");

        $this->assertTrue($user->getFirstname() === "Ange");
        $this->assertTrue($user->getLastname() === "PLANITEYE");
        $this->assertTrue($user->getBirthday() === $date);
        $this->assertTrue($user->getEmail() === "bplaniteye@gmail.com");
        $this->assertTrue($user->getPassword() === "123456");
        $this->assertTrue($user->getAddress() === "1 rue Crevoulin 77000 Melun");
    }

    public function testFalse(): void
    {
        $user = new User;
        $date = new \Datetime;
        $user->setFirstname("Ange");
        $user->setLastname("PLANITEYE");
        $user->setBirthday($date);
        $user->setEmail("bplaniteye@gmail.com");
        $user->setPassword("123456");
        $user->setAddress("1 rue Crevoulin 77000 Melun");
        //$user->setRoles("ROLE_USER");

        $this->assertFalse($user->getFirstname() !== "Ange");
        $this->assertFalse($user->getLastname() !== "PLANITEYE");
        $this->assertFalse($user->getBirthday() !== $date);
        $this->assertFalse($user->getEmail() !== "bplaniteye@gmail.com");
        $this->assertFalse($user->getPassword() !== "123456");
        $this->assertFalse($user->getAddress() !== "1 rue Crevoulin 77000 Melun");
        //$this->assertFalse($user->getRoles() !== "ROLE_USER");
    }

    public function testEmpty(): void
    {
        $user = new User;
        $this->assertEmpty($user->getFirstname());
        $this->assertEmpty($user->getLastname());
        $this->assertEmpty($user->getBirthday());
        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getPassword());
        $this->assertEmpty($user->getAddress());
        $this->assertEmpty($user->getRoles());
    }
}
