<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Form\SearchFormType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_index", methods={"GET" , "POST"})
     */
    public function index(ArticleRepository $articleRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $articles = $articleRepository->findAll();

        $form = $this->createForm(SearchFormType::class);
        $search = $form->handleRequest($request);
        $articles_search = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $articles_search = $articleRepository->searchFulltext($search->get('value')->getData());
        }

        $articles_page = $paginator->paginate(
            $articles,
            $request->query->getInt('page', 1),
            12
        );
        return $this->render('article/index.html.twig', [            
            'articles' => $articles,
            //'nbarticles' => count($articles),           
            'articles_page' => $articles_page,
            //'nb_articles_page' => count($articles_page),            
            'articles_search' => $articles_search,
            //'nb_articles_search' => count($articles_search),
           // 'slug' => $articles->getSlug(),
            'search_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $images = $form->get('images')->getData();
            // foreach ($images as $image) 
            // {
            //     $file = uniqid("img_", true ) . "." . $image->guessExtension();
            //     $image->move($this->getParameter('images_directory'), $file);
            //     $img = new Image;
            //     $img->setName($file);
            //     $article->addImage($img);
            // }

            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,            
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $images = $form->get('images')->getData();
            foreach ($images as $image) 
            {
                $file = uniqid("img_", true) . "." . $image->guessExtension();
                $image->move($this->getParameter('images_directory'), $file);
                $img = new Image;
                $img->setName($file);
                $article->addImage($img);
            }            
            $entityManager->flush();

            return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"POST"})
     */
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
    }
}
