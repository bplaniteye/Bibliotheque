<?php

namespace App\Controller;

use Faker;
use Faker\Factory;
use App\Entity\Auteurs;
use App\Form\AuteursType;
use App\Repository\AuteursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuteursController extends AbstractController
{
    // TABLEAU DES AUTEURS
    /**
     * @Route("/auteurs", name="index_auteurs")
     */
    public function auteursIndex(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Auteurs::class);
        $auteurs = $repo->findAll();
        return $this->render('auteurs/auteurs_index.html.twig', [
            'page' => 'Auteurs',
            'auteurs' => $auteurs
        ]);
    }

    // CREATION DES AUTEURS
    /**
     * @Route("/auteurs_creation", name="index_auteurs_creation", methods={"GET","POST"})
     */
    public function auteurs(Request $request, EntityManagerInterface $em): Response
    {
        for ($i = 0; $i < 20; $i++) {
            $faker = Faker\Factory::create('fr_FR');
            $auteurs = new Auteurs;
            $auteurs->setNom($faker->lastName())
                ->setPrenom($faker->firstName())
                ->setEmail($faker->email());
                -
            $em->persist($auteurs);
            $em->flush();
        }
        return $this->render('auteurs/auteurs_creation.html.twig', [
            'controller_name' => 'AuteursController',
            'auteurs' => $auteurs
        ]);
    }

    /**
     * @Route("auteurs_Informations/{id}", name="index_auteurs_informations", methods={"GET"})
     */
    public function auteursInformations(Auteurs $auteur, AuteursRepository $auteursRepository, Request $request, EntityManagerInterface $manager): Response
    {
        return $this->render('auteurs/auteurs_informations.html.twig', [
            'id' => $auteur->getId(),
            //'articles' => $auteur->getArticles(),
            'auteur' => $auteur,
        ]);
    }

    /**
     * @Route("/auteurs_inscription", name="index_auteurs_inscription", methods={"GET","POST"})
     */
    public function auteursInscription(Request $request): Response
    {
        $auteurs = new Auteurs();
        $form = $this->createForm(AuteursType::class, $auteurs);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($auteurs);
            $entityManager->flush();
            return $this->redirectToRoute('index_auteurs_affichage', ['id' => $auteurs->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('auteurs/auteurs_inscription.html.twig', [
            'auteurs' => $auteurs,
            'auteurs_inscription' => $form->createView(),
        ]);
    }
}
