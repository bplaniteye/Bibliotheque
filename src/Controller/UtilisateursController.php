<?php
namespace App\Controller;
use App\Entity\Utilisateurs;
use App\Form\UtilisateursType;
use App\Repository\UtilisateursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Faker;

class UtilisateursController extends AbstractController
{
    // FORMULAIRE DE CREATION DES UTILISATEURS
    /**
     * @Route("/utilisateurs_formulaire", name="index_utilisateurs_formulaire", methods={"GET","POST"})
     */
    public function utilisateursFormulaire(Request $request): Response
    {
        $utilisateurs = new Utilisateurs();
        $form = $this->createForm(UtilisateursType::class, $utilisateurs);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($utilisateurs);
            $entityManager->flush();
            return $this->redirectToRoute('index_utilisateurs_affichage', ['id' => $utilisateurs->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('utilisateurs/utilisateurs_formulaire.html.twig', [
            'utilisateurs' => $utilisateurs,
            'utilisateursFormulaire' => $form->createView(),
        ]);
    }

    // FORMULAIRE DE MODIFICATION DES UTILISATEURS
    /**
     * @Route("/utilisateurs_modification/{id}" , name="index_utilisateurs_modification", methods= {"GET","POST"})
     */
    public function utilisateursModification (Request $request, Utilisateurs $utilisateurs) : Response 
    {

        $form= $this->createForm(UtilisateursType::class , $utilisateurs);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('index_utilisateurs_affichage' , ['id'=> $utilisateurs->getId()]);
        }
        return $this->render('utilisateurs/utilisateurs_modification.html.twig', ['utilisateurs'=> $utilisateurs->getId(), 
        'formUtilisateurs'=>$form->createView(),
    ]);
    }

    // AFFICAHGE D'UN UTILISATEUR ET SES INFORMATIONS
    /**
     * @Route("/utilisateurs_affichage/{id}", name="index_utilisateurs_affichage", methods={"GET"})
     */
    public function utilisateursAffichage(Utilisateurs $utilisateurs, UtilisateursRepository $utilisateursRepository, Request $request, EntityManagerInterface $manager ): Response
    {
        return $this->render('utilisateurs/utilisateurs_affichage.html.twig', [
            'id'=>$utilisateurs->getId(),
            'utilisateurs' => $utilisateurs,
        ]);
    }

    // SUPPRESSION DES UTILISATEURS
    /**
     * @Route("/utilisateurs_suppression/{id}" , name="index_utilisateurs_suppression", methods= {"GET","POST"})
     */
    public function utilisateursSuppression (Request $request, Utilisateurs $utilisateurs , EntityManagerInterface $entityManager) : Response 
    {           
            $entityManager->remove($utilisateurs);
            $entityManager->flush();
            return $this->redirectToRoute('index_utilisateurs'); 
    }

    // TABLEAU DES UTILISATEURS
    /**
     * @Route("/utilisateurs", name="index_utilisateurs")
     */
    public function utilisateursIndex(): Response
    {
        $repo= $this->getDoctrine()->getRepository(Utilisateurs::class);
        $utilisateurs = $repo->findAll();

        return $this->render('utilisateurs/utilisateurs_index.html.twig', [
            'controller_name' => 'UtilisateursController',
            'utilisateurs' => $utilisateurs,
        ]);
    }

    // CREATION DES UTILISATEURS
    /**
     * @Route("/utilisateurs_creation", name="index_utilisateurs_creation", methods={"GET","POST"})
     */
    public function utilisateursCreation(Request $request, EntityManagerInterface $em): Response
    {
        for ($i=0;$i<50;$i++)
        {
            $faker = Faker\Factory::create('fr_FR');
            $utilisateurs = new Utilisateurs();
            $tab = ["admin","usager"];
            shuffle($tab);
            $utilisateurs->setNom($faker->lastName());
            $utilisateurs->setPrenom($faker->firstName()) ;   
        $utilisateurs->setNaissance (new \DateTime());
            $utilisateurs->setPhoto("Photo de profil");
            $utilisateurs->setEmail($faker->email());
            $utilisateurs->setAdresse($faker->address());
            $utilisateurs->setLogin($faker->userName()) ;                    
                $utilisateurs->setMotdepasse( password_hash("mdp" , PASSWORD_DEFAULT) );
            $utilisateurs->setRole($tab[0]) ;                
       $em->persist($utilisateurs);
        }   
       $em->flush();
       return $this->render('utilisateurs/utilisateurs_creation.html.twig', [
           'utilisateurs' => $utilisateurs,
       ]);
    }
    
    
}
