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

        $user = $this->getUser();

            if (!$user instanceof \App\Entity\Utilisateur) {
                $coefficient = 1.2; 
            } else {
                $coefficient = (float) $user->getCoefficient();
            }


        if ($request->isMethod('POST')) {

            $token = new CsrfToken('authenticate', $request->request->get('_csrf_token'));
            if (!$csrfTokenManager->isTokenValid($token)) {
                throw new \Exception('Jeton CSRF invalide.');
            }
    
            $produitId = $request->request->get('produit_id');
            $action = $request->request->get('action', 'supprimer'); 
            
            if ($produitId && is_numeric($produitId)) {
                
                if ($action === 'modifier') {
                    
                    $nouvelleQuantite = $request->request->get('quantite');
                    
                    if ($nouvelleQuantite !== null && is_numeric($nouvelleQuantite)) {
                        $nouvelleQuantite = (int)$nouvelleQuantite;

                        if ($nouvelleQuantite > 10) {
                            $this->addFlash('error', 'Quantité limitée à 10 par produit dans le panier.');
                            return $this->redirectToRoute('app_panier');
                        }
                        
                        if ($nouvelleQuantite <= 0) {
                            $panierService->supprimerProduit((int)$produitId);
                            $this->addFlash('success', 'Produit supprimé du panier');
                        } else {
                            $panierService->modifierQuantite((int)$produitId, $nouvelleQuantite);
                            $this->addFlash('success', 'Quantité modifiée avec succès');
                        }
                    } else {
                        $this->addFlash('error', 'Quantité invalide');
                    }
                } else {
                    
                    $panierService->supprimerProduit((int)$produitId);
                    $this->addFlash('success', 'Produit supprimé du panier');
                }
                
                return $this->redirectToRoute('app_panier');
            }
        }
        
        // dump($request->getSession()->get('panier', []));
        
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
                $prixBase = $produit->getPrixHt() * $coefficient;

                $prixTTC = $prixBase;

                if ($produit->getPromotion() !== null && $produit->getPromotion() > 0) {
                    $prixTTC = $prixBase * (1 - $produit->getPromotion());
                }

                $sousTotal = $prixTTC * $quantite;

                $detailsPanier[] = [
                    'produit' => $produit,
                    'quantite' => $quantite,
                    'prixBase' => $prixBase,
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