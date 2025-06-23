<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\AdresseLivraisonForm;
use App\Form\AdresseFacturationForm;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

final class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
         if (!$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $this->addFlash('error', 'Vous devez être <a href="/connexion">connecté</a> pour accéder à votre Profil.');
            return $this->redirectToRoute('app_accueil');
        }
    /** @var \App\Entity\Utilisateur $user */
    $user = $this->getUser();

    $formLivraison = $this->createForm(AdresseLivraisonForm::class, $user);
    $formFacturation = $this->createForm(AdresseFacturationForm::class, $user);

    $formLivraison->handleRequest($request);
    $formFacturation->handleRequest($request);

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

    return $this->render('profil/index.html.twig', [
        'formLivraison' => $formLivraison->createView(),
        'formFacturation' => $formFacturation->createView(),
    ]);
}}