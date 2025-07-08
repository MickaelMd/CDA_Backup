<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CommandeRepository;
use App\Repository\FournisseurRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;

final class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(CommandeRepository $commandeRepository, UtilisateurRepository $utilisateurRepository, ProduitRepository $produitRepository, FournisseurRepository $fournisseurRepository, CategorieRepository $categorieRepository): Response
    {

          if (!$this->isGranted('ROLE_COMMERCIAL') && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'avez pas les droits pour accéder à cette page.');
            return $this->redirectToRoute('app_accueil');
        }

        $fournisseur = $fournisseurRepository->findAll();
        $produit = $produitRepository->findAll();
        $commande = $commandeRepository->findAll();
        $categorie = $categorieRepository->findAll();


        $qb = $utilisateurRepository->createQueryBuilder('u');
        $qb->where('u.roles LIKE :role')
        ->setParameter('role', '%ROLE_COMMERCIAL%');

        $commercial = $qb->getQuery()->getResult();


        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'fournisseur' => $fournisseur,
            'produit' => $produit,
            'commercial' => $commercial,
            'commande' => $commande,
            'categorie' => $categorie,
        ]);
    }
}



//   $token = new CsrfToken('authenticate', $request->request->get('_csrf_token'));
        // if (!$csrfTokenManager->isTokenValid($token)) {
            // throw new \Exception('Jeton CSRF invalide.');
        // }