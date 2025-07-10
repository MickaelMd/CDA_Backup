<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;

final class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(CategorieRepository $categorieRepository, ProduitRepository $produitRepository): Response
    {

       $categorie = $categorieRepository->findBy(['active' => 1]);
    //    $produit = $produitRepository->findBy(['active' => 1]); 

       $produit = $produitRepository->produitpopulaire(4);
      

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'categorie' => $categorie,
            'produit' => $produit
        ]);
    }
}