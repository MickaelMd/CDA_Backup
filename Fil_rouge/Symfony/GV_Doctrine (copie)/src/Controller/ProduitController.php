<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProduitRepository;
use App\Service\PanierService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class ProduitController extends AbstractController
{
   #[Route('/produit/{id}', name: 'app_produit', methods: ['GET', 'POST'])]
public function index(
    string $id,
    Request $request,
    PanierService $panierService,
    ProduitRepository $produitRepository,
    CsrfTokenManagerInterface $csrfTokenManager
): Response
{
    $produit = $produitRepository->find($id);

    if (!$produit) {
        return $this->redirectToRoute('app_accueil');
    }

    if ($request->isMethod('POST')) {
        
    $token = new CsrfToken('authenticate', $request->request->get('_csrf_token'));
        if (!$csrfTokenManager->isTokenValid($token)) {
            throw new \Exception('Jeton CSRF invalide.');
        }
    $quantite = $request->request->getInt('quantite', 1);
    $panier = $panierService->getPanier(); 
    $quantiteActuelle = $panier[$produit->getId()] ?? 0;
    $quantiteTotale = $quantiteActuelle + $quantite;
    if ($quantiteTotale > 10) {
        $this->addFlash('error', 'Quantité limitée à 10 par produit dans le panier.');
        return $this->redirectToRoute('app_produit', ['id' => $id]);
    }
    $panierService->ajouterProduit($produit->getId(), $quantite);
    $this->addFlash('success', 'Produit ajouté au panier !');
    return $this->redirectToRoute('app_produit', ['id' => $id]);
}
    return $this->render('produit/index.html.twig', [
        'produit' => $produit
    ]);

}
    
}