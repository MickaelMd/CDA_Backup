<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\SousCategorieRepository;
use App\Repository\ProduitRepository;

final class SousCategorieController extends AbstractController
{
    #[Route('/sous-categorie/{id}', name: 'app_sous_categorie')]
    public function index(int $id, SousCategorieRepository $sousCategorieRepository): Response
    {
        $souscat = $sousCategorieRepository->findOneBy(['id' => $id]);

        if (!$souscat) {
            return $this->redirectToRoute('app_accueil');
        }
        
        
        $produits = $souscat->getProduits()->filter(function($produit) {
            return $produit->isActive();
        });

        return $this->render('sous_categorie/index.html.twig', [
            'controller_name' => 'SousCategorieController',
            'souscat' => $souscat,
            'produits' => $produits
        ]);
    }
}