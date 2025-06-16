<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Produit;
use App\Repository\ProduitRepository;

class PanierService
{
    private SessionInterface $session;
    private ProduitRepository $produitRepository;

      public function __construct(RequestStack $requestStack, ProduitRepository $produitRepository)
    {
        $this->session = $requestStack->getSession();
        $this->produitRepository = $produitRepository;
    }

    public function ajouterProduit(int $produitId, int $quantite = 1): void
    {
        $panier = $this->session->get('panier', []);
        
        if (isset($panier[$produitId])) {
            $panier[$produitId] += $quantite;
        } else {
            $panier[$produitId] = $quantite;
        }
        
        $this->session->set('panier', $panier);
    }

    public function getPanier(): array
    {
        return $this->session->get('panier', []);
    }

    
    }