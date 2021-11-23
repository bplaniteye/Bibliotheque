<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Articles;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Faker; 

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories_formulaire", name="index_categories_formulaire", methods={"GET","POST"})
     */
    public function categoriesFormulaire(Request $request): Response
    {
        $categories = new Categories();
        $form = $this->createForm(CategoriesType::class, $categories);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categories);
            $entityManager->flush();
            return $this->redirectToRoute('index_categories', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('categories/categories_formulaire.html.twig', [
            'categories' => $categories,
            'categoriesFormulaire' => $form->createView(),
        ]);
    }

    /**
     * @Route("/categories_modification/ {id}", name="index_categories_modification" , methods={"GET", "POST"})
     */
    // Ici on Fait une Enregistrement avec une Formulaire

    public function edit_categorie(Request $request, EntityManagerInterface $manager , Categories $categories)
    {
        $form = $this->createForm(CategoriesType::class, $categories);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();           
            $entityManager->flush();
            return $this->redirectToRoute('index_categories', [], Response::HTTP_SEE_OTHER);
        } 
        // Redirection du Formulaire vers le TWIG pour l’affichage avec
        return $this->render('categories/categories_modification.html.twig', [
            'categories' => $categories->getId(),
            'categoriesFormulaire' => $form->createView()
        ]);
    }

    /**
     * @Route("/categories", name="index_categories")
     */
    public function index(): Response
    {   
        $repo= $this->getDoctrine()->getRepository(Categories::class);
        $categories = $repo->findAll();

        return $this->render('categories/categories_index.html.twig', [
            'controller_name' => 'CategorieController',
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/categories_creation", name="index_categories_creation", methods={"GET", "POST"})
     */
    public function categoriesCreation(Request $request, EntityManagerInterface $em): Response
    {
        //$faker = Faker\Factory::create('fr_FR');
        $cat = ["Roman", "BD", "Recueil", "Essai", "Magazine", "Journal"];
        $nbcat = count($cat);
        for ($i = 0; $i < $nbcat; $i++) {
            $categories = new Categories();
            $categories->setCategories($cat[$i]);
            $em->persist($categories); 
        }
       $em->flush();
       // J'envoie au niveau du temple pour l'enregistrement
       return $this->render('categories/categories_creation.html.twig', [
           'categories' => $categories,
       ]);
    }

    
    /**
     * @Route("categories_affichage/{id}", name="index_categories_affichage", methods={"GET"})
     */
    public function categoriesAffichage(Categories $categories): Response
    {
        return $this->render('categories/categories_affichage.html.twig', [
            'id'=>$categories->getId(),
            'articles' =>$categories->getArticles(),
            'categories' => $categories,
        ]);
    }
}
