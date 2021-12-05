<?php

namespace App\Controller;

use App\Entity\Auteurs;
use App\Form\AuteursType;
use App\Entity\Utilisateurs;
use App\Form\UtilisateursType;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/utilisateurs_inscriptiuon", name="index_utilisateurs_inscription")
     */
    public function utilisateursInscriptiuon(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, EntityManagerInterface $entityManager): Response
    {
        $utilisateurs = new Utilisateurs();
        $form = $this->createForm(UtilisateursType::class, $utilisateurs);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $utilisateurs->setPassword(
            $userPasswordEncoder->encodePassword(
                    $utilisateurs,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($utilisateurs);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('index_abonne');
        }

        return $this->render('utilisateurs/utilisateurs_inscription.html.twig', [
            'utilisateurs_inscription' => $form->createView(),
        ]);
    }

     /**
     * @Route("/auteurs_inscriptiuon", name="index_auteurs_inscription")
     */
    public function auteursInscriptiuon(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, EntityManagerInterface $entityManager): Response
    {
        $auteurs = new Auteurs();
        $form = $this->createForm(AuteursType::class, $auteurs);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $auteurs->setPassword(
            $userPasswordEncoder->encodePassword(
                    $auteurs,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($auteurs);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('index_abonne');
        }

        return $this->render('auteurs/auteurs_inscription.html.twig', [
            'auteurs_inscription' => $form->createView(),
        ]);
    }
}
