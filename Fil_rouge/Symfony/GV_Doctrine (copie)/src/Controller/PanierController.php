<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProduitRepository;
use App\Service\PanierService;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(
        Request $request,
        PanierService $panierService,
        ProduitRepository $produitRepository,
        CsrfTokenManagerInterface $csrfTokenManager
    ): Response {
        
        dump($request->getSession()->get('panier', []));
        
        $panier = $panierService->getPanier(); 

        if (empty($panier)) {
            $this->addFlash('error', 'Votre panier est vide.');
            return $this->redirectToRoute('app_accueil');
        }

        $detailsPanier = [];
        $totalPanier = 0;
        
        foreach ($panier as $produitId => $quantite) {
        
            $produit = $produitRepository->find($produitId);

            if ($produit) {
                $prixTTC = $produit->getPrixHt() * 1.2;
                $sousTotal = $prixTTC * $quantite;
                $detailsPanier[] = [
                    'produit' => $produit,
                    'quantite' => $quantite,
                    'prixTTC' => $prixTTC,
                    'sousTotal' => $sousTotal
                ];
                
                $totalPanier += $sousTotal;
            }
        }

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'detailsPanier' => $detailsPanier,
            'totalPanier' => $totalPanier,
            'nombreArticles' => array_sum($panier)
        ]);
    }
}