<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Categories;
use App\Form\ArticlesType;
use Doctrine\ORM\EntityManager;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("articles")
 */

class ArticlesController extends AbstractController
{
    /**
     * @Route("/articles_formulaire", name="index_articles_formulaire", methods={"GET","POST"})
     */
    public function articlesFormulaire(Request $request): Response
    {
        $articles = new Articles();
        $form = $this->createForm(ArticlesType::class, $articles);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($articles);
            $entityManager->flush();
            return $this->redirectToRoute('index_articles_affichage', ['id' => $articles->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('articles/articles_formulaire.html.twig', [
            'articles' => $articles,
            'articlesFormulaire' => $form->createView(),
        ]);
    }

    /**
     * @Route("/articles_modification/{id}", name="index_articles_modification" , methods={"GET", "POST"})
     */
    // Ici on Fait une Enregistrement avec une Formulaire
    public function articleModification(Request $request, EntityManagerInterface $manager, Articles $articles)
    {
        // Creation de mon Formulaire
        $form = $this->createForm(ArticlesType::class, $articles);
        // Analyse des Requetes & Traitement des information 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$manager->persist($articles);
            $manager->flush();
            return $this->redirectToRoute(
                'index_articles_affichage',
                ['id' => $articles->getId()]
            );
        }

        // Redirection du Formulaire vers le TWIG pour l’affichage avec
        return $this->render('articles/articles_modification.html.twig', [
            'articles' => $articles->getId(),
            'articlesFormulaire' => $form->createView()
        ]);
    }

    /**
     * @Route("/", name="index_articles")
     */

    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Articles::class);
        $articles = $repo->findAll();

        return $this->render('articles/articles_index.html.twig', [
            'controller_name' => 'ArticlesController',
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/articles_creation", name="index_articles_creation", methods={"GET", "POST"})
     */
    public function articlesCreation(Request $request, EntityManagerInterface $em): Response
    {
        $cat = ["Roman", "BD", "Recueil", "Essai", "Magazine", "Journal"];
        $nbcat = count($cat);
        for ($i = 0; $i < $nbcat; $i++) 
        {
            $categories = new Categories();
            $categories->setCategories($cat[$i]);
            $em->persist($categories);

            for ($j = 0; $j < 5; $j++) 
            {
                $articles = new Articles();
                // Ici je fais un enregistrement Manuel, on verra la suite avec le  Formulaire
                $articles->setTitre(" Titre $j");
                $articles->setImage(" Image $j");
                $articles->setResume("Résumé de l'article $j");
                $articles->setDate(new  \DateTime());
                $articles->setContenu(" Contenu de l'article $j");
                $articles->setCategories($categories);
                // Je persiste Mon Enregistrement
                $em->persist($articles);
            }
        }
        $em->flush();
        // J'envoie au niveau du temple pour l'enregistrement
        return $this->render('articles/articles_creation.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/{id}", name="index_articles_affichage", methods={"GET"})
     */
    public function articleAffichage(Articles $articles, ArticlesRepository $articlesRepository, Request $request, EntityManagerInterface $manager): Response
    {
        return $this->render('articles/articles_affichage.html.twig', [
            'id' => $articles->getId(),
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/{id}", name="index_articles_suppression", methods={"GET" , "POST"})
     */
    public function articleSuppression(Request $request, Articles $article): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }
        return $this->redirectToRoute('index_articles', [], Response::HTTP_SEE_OTHER);
    }
}
