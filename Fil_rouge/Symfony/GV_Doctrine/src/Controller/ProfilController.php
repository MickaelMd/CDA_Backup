<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\AdresseLivraisonForm;
use App\Form\AdresseFacturationForm;
use App\Form\ProfilEmailForm;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Repository\CommandeRepository;
use App\Form\ChangeEmailForm;

final class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(
        Request $request, 
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        CommandeRepository $commandeRepository
    ): Response {
        if (!$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $this->addFlash('error', 'Vous devez être <a href="/connexion">connecté</a> pour accéder à votre Profil.');
            return $this->redirectToRoute('app_accueil');
        }

        /** @var \App\Entity\Utilisateur $user */
        $user = $this->getUser();

        $commande = $commandeRepository->findBy(
            ['Client' => $user],
            ['dateCommande' => 'DESC'],
            3
        );


      
        $formLivraison = $this->createForm(AdresseLivraisonForm::class, $user);
        $formFacturation = $this->createForm(AdresseFacturationForm::class, $user);
        $formPassword = $this->createForm(ProfilEmailForm::class, $user);
        $formEmail = $this->createForm(ChangeEmailForm::class, $user);

      
        $formLivraison->handleRequest($request);
        $formFacturation->handleRequest($request);
        $formPassword->handleRequest($request);
        $formEmail->handleRequest($request); 

       
        if ($formLivraison->isSubmitted() && $formLivraison->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Adresse de livraison mise à jour.');
            return $this->redirectToRoute('app_profil');
        }

       
        if ($formFacturation->isSubmitted() && $formFacturation->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Adresse de facturation mise à jour.');
            return $this->redirectToRoute('app_profil');
        }

      
        if ($formPassword->isSubmitted() && $formPassword->isValid()) {
            $currentPassword = $formPassword->get('currentPassword')->getData();
            $newPassword = $formPassword->get('newPassword')->get('first')->getData();

            if (!$passwordHasher->isPasswordValid($user, $currentPassword)) {
                $this->addFlash('error', 'Le mot de passe actuel est incorrect.');
            } else {
                $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hashedPassword);
                
                $em->flush();
                $this->addFlash('success', 'Votre mot de passe a été modifié avec succès.');
                return $this->redirectToRoute('app_profil');
            }
        }

    
        if ($formEmail->isSubmitted() && $formEmail->isValid()) {
            $currentPassword = $formEmail->get('currentPassword')->getData();
            $newEmail = $formEmail->get('email')->getData();

            if (!$passwordHasher->isPasswordValid($user, $currentPassword)) {
                $this->addFlash('error', 'Le mot de passe actuel est incorrect.');
            } else {
                $existingUser = $em->getRepository(\App\Entity\Utilisateur::class)->findOneBy(['email' => $newEmail]);
                if ($existingUser && $existingUser->getId() !== $user->getId()) {
                    $this->addFlash('error', 'Cette adresse email est déjà utilisée par un autre compte.');
                } else {
                    $user->setEmail($newEmail);
                    $em->flush();
                    $this->addFlash('success', 'Votre adresse email a été modifiée avec succès.');
                    return $this->redirectToRoute('app_profil');
                }
            }
        }


        return $this->render('profil/index.html.twig', [
            'formLivraison' => $formLivraison->createView(),
            'formFacturation' => $formFacturation->createView(),
            'formPassword' => $formPassword->createView(),
            'commande' => $commande,
            'formEmail' => $formEmail->createView(),
        ]);
    }


#[Route('/profil/listecommande', name: 'app_profil_commande')]
public function confirmation(CommandeRepository $commandeRepository): Response
{

      if (!$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $this->addFlash('error', 'Vous devez être <a href="/connexion">connecté</a> pour accéder à votre Profil.');
            return $this->redirectToRoute('app_accueil');
        }

        /** @var \App\Entity\Utilisateur $user */
        $user = $this->getUser();

        $commande = $commandeRepository->findBy(
            ['Client' => $user],
          
        );


    return $this->render('profil/listecommande.html.twig', [
        'commande' => $commande,
    ]);
}

}