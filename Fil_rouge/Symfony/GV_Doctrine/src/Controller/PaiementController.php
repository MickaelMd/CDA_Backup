<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProduitRepository;
use App\Service\PanierService;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;


final class PaiementController extends AbstractController
{
    #[Route('/paiement', name: 'app_paiement')]
    public function index(PanierService $panierService, ProduitRepository $produitRepository): Response
    {

        if (!$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $this->addFlash('error', 'Vous devez être <a href="/connexion">connecté</a> pour valider votre commande.');
            return $this->redirectToRoute('app_panier');
        }

         $panier = $panierService->getPanier(); 

        if (empty($panier)) {
            $this->addFlash('error', 'Votre panier est vide.');
            return $this->redirectToRoute('app_accueil');
        }

        $user = $this->getUser();
        $detailsPanier = [];
        $totalPanier = 0;
         if (!$user instanceof \App\Entity\Utilisateur) {
                $coefficient = 1.2; 
            } else {
                $coefficient = (float) $user->getCoefficient();
            }
        
        foreach ($panier as $produitId => $quantite) {
        
            $produit = $produitRepository->find($produitId);

            if ($produit) {
                $prixTTC = $produit->getPrixHt() * $coefficient;
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

        return $this->render('paiement/index.html.twig', [
            'controller_name' => 'PaiementController',
            'detailsPanier' => $detailsPanier,
            'totalPanier' => $totalPanier,
            'nombreArticles' => array_sum($panier)
        ]);
    }
}