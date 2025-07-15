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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Fournisseur;



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
         $categorie = $categorieRepository->findBy(['active' => true]);
        foreach ($categorie as $cat) {
            $cat->getSousCategories()->count(); 
        }


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

    #[Route('/admin-update-fournisseur', name: 'app_admin_update_fournisseur', methods: ['POST'])]
    public function updateFournisseur(
        Request $request,
        FournisseurRepository $fournisseurRepository,
        UtilisateurRepository $utilisateurRepository,
        EntityManagerInterface $entityManager,
        CsrfTokenManagerInterface $csrfTokenManager
    ): Response {
        
        $token = new CsrfToken('authenticate', $request->request->get('_csrf_token'));
        if (!$csrfTokenManager->isTokenValid($token)) {
            throw new \Exception('Jeton CSRF invalide.');
        }

        try {

                $id = $request->request->get('fourni-id');
                $nom = $request->request->get('fourni-nom');
                $email = $request->request->get('fourni-email');
                $telephone = $request->request->get('fourni-telephone');
                $adresse = $request->request->get('fourni-adresse');
                $commercialId = $request->request->get('commercial-id'); 
                
                $errors = [];

                if (empty(trim($nom))) {
                    $errors[] = 'Le nom du fournisseur est obligatoire.';
                }

                if (empty(trim($email))) {
                    $errors[] = 'L\'email du fournisseur est obligatoire.';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'L\'email du fournisseur n\'est pas valide.';
                }

                if (empty(trim($telephone))) {
                    $errors[] = 'Le téléphone du fournisseur est obligatoire.';
                }

                if (empty(trim($adresse))) {
                    $errors[] = 'L\'adresse du fournisseur est obligatoire.';
                } elseif (strlen(trim($adresse)) < 10) {
                    $errors[] = 'L\'adresse du fournisseur doit contenir au moins 10 caractères.';
                }

                if (empty($commercialId)) {
                    $errors[] = 'Un commercial doit être assigné au fournisseur.';
                }

               
                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        $this->addFlash('error', $error);
                    }
                    return $this->redirectToRoute('app_admin');
                }

                if ($id) {
                    $fournisseur = $fournisseurRepository->find($id);
                    if (!$fournisseur) {
                        throw $this->createNotFoundException('Fournisseur introuvable.');
                    }
                } else {
                    $fournisseur = new Fournisseur();
                }

                $fournisseur->setNom(trim($nom));
                $fournisseur->setEmail(trim($email));
                $fournisseur->setTelephone(trim($telephone));
                $fournisseur->setAdresse(trim($adresse));

                if ($commercialId) {
                    $commercial = $utilisateurRepository->find($commercialId);
                    if ($commercial) {
                        $fournisseur->setCommercial($commercial);
                    } else {
                        $this->addFlash('error', 'Commercial introuvable.');
                        return $this->redirectToRoute('app_admin');
                    }
                }

                $entityManager->persist($fournisseur);
                $entityManager->flush();
                $this->addFlash('success', 'Fournisseur ajouté ou mis à jour avec succès.');
                return $this->redirectToRoute('app_admin');
        } catch (\Exception $e) {
                        $this->addFlash('error', 'Une erreur s\'est produite, veuillez réessayer.');
                        return $this->redirectToRoute('app_admin');
                }
    }

    #[Route('/admin-update-produit', name: 'app_admin_update_produit', methods: ['POST'])]
    public function updateProduit(
        Request $request,
        ProduitRepository $produitRepository,
        UtilisateurRepository $utilisateurRepository,
        EntityManagerInterface $entityManager,
        CsrfTokenManagerInterface $csrfTokenManager
    ): Response { 

          $token = new CsrfToken('authenticate', $request->request->get('_csrf_token'));
        if (!$csrfTokenManager->isTokenValid($token)) {
            throw new \Exception('Jeton CSRF invalide.');
        }

    try {

        $lib_court = $request->request->get('produit-libelle_court');
        $lib_long = $request->request->get('produit_libelle_long');
        $stock = $request->request->get('produit-stock');
        $prixHt = $request->request->get('produit-prixht');
        $prixFourni = $request->request->get('produit-prixFournisseur');
        $promotion = $request->request->get('produit-promotion');
        $fournisseur = $request->request->get('produit-fourni');
        $souscat = $request->request->get('produit-sous_categorie');
        $image = $request->request->get('produit-image');
        $active = $request->request->get('produit-active');

        $errors = [];

         if (empty(trim($lib_court))) {
                    $errors[] = 'Le nom du produit est obligatoire.';
                }
        
         if (empty(trim($lib_long))) {
                    $errors[] = 'La description du produit est obligatoire.';
                }
         if (empty(trim($stock))) {
                    $errors[] = 'Le nombre de produit en stock est obligatoire.';
                }
         if (empty(trim($prixHt))) {
                    $errors[] = 'Le prix hors taxe du produit est obligatoire.';
                }
        if (empty(trim($prixFourni))) {
                    $errors[] = 'Le prix fournisseur du produit est obligatoire.';
                }
        if (empty(trim($fournisseur))) {
            $errors[] = 'Le nom du fournisseur du produit est obligatoire.';
        }
        if (empty(trim($souscat))) {
            $errors[] = 'La catégorie du produit est obligatoire.';
        }

        if (empty(trim($souscat))) {
            $errors[] = 'L\'image du produit est obligatoire.';
        }
               
        if (!empty($errors)) {
                            foreach ($errors as $error) {
                                $this->addFlash('error', $error);
                            }
                            return $this->redirectToRoute('app_admin');
                        }

        $this->addFlash('success', 'Le produit a été ajouté ou mis à jour avec succès.');
        return $this->redirectToRoute('app_admin');
    } catch (\Exception $e) {
                    $this->addFlash('error', 'Une erreur s\'est produite, veuillez réessayer.');
                    return $this->redirectToRoute('app_admin');
        }
    


   

    }

}



//   $token = new CsrfToken('authenticate', $request->request->get('_csrf_token'));
        // if (!$csrfTokenManager->isTokenValid($token)) {
            // throw new \Exception('Jeton CSRF invalide.');
        // }