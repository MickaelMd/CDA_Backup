<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProduitRepository;

final class ProduitController extends AbstractController
{
    #[Route('/produit/{id}', name: 'app_produit')]
    public function index(string $id, ProduitRepository $produitRepository): Response
    {
    
        $produit = $produitRepository->findOneBy(['id' => $id]);

        if (!$produit) {
            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
            'produit' => $produit
        ]);
    }
}