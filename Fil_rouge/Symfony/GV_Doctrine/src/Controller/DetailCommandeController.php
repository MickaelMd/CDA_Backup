<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class DetailCommandeController extends AbstractController
{
    #[Route('/commande/{id}', name: 'app_detail_commande', methods: ['GET'])]
    public function index(
        int $id,
        CommandeRepository $commandeRepository,
    ): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $this->addFlash('error', 'Vous devez être <a href="/connexion">connecté</a> pour accéder à votre commande.');
            return $this->redirectToRoute('app_accueil');
        }

        /** @var \App\Entity\Utilisateur $user */
        $user = $this->getUser();

        $commande = $commandeRepository->find($id);

        if (!$commande) {
           $this->addFlash('error', 'Vous n\'avez pas accès à cette commande.');
            return $this->redirectToRoute('app_accueil');
        }

        if ($commande->getClient() !== $user) {
            $this->addFlash('error', 'Vous n\'avez pas accès à cette commande.');
            return $this->redirectToRoute('app_accueil');
        }


        return $this->render('detail_commande/index.html.twig', [
            'commande' => $commande,
            'controller_name' => 'DetailCommandeController',
        ]);
    }
}