<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

  /**
     * @Route("/", name="home")
     */

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index_home")
     */
    public function accueil(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

     /**
     * @Route("/", name="index_admin")
     */
    public function admin(): Response
    {
        return $this->render('home/admin_index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

     /**
     * @Route("/", name="index_abonne")
     */
    public function abonne(): Response
    {
        return $this->render('home/abonne_index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
