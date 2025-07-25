<?php

namespace App\Controller;

use App\Entity\DetailCommande;
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
use app\Entity\Produit;
use app\Entity\SousCategorie;
use App\Repository\DetailCommandeRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileException;



final class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(CommandeRepository $commandeRepository, UtilisateurRepository $utilisateurRepository, ProduitRepository $produitRepository, FournisseurRepository $fournisseurRepository, CategorieRepository $categorieRepository): Response
    {

          if (!$this->isGranted('ROLE_COMMERCIAL') && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'avez pas les droits pour accéder à cette page.');
            return $this->redirectToRoute('app_accueil');
        }

        $fournisseur = $fournisseurRepository->findBy([], ['nom' => 'ASC']);
        $produit = $produitRepository->findBy([], ['libelleCourt' => 'ASC']);
         $categorie = $categorieRepository->findBy(['active' => true], ['nom' => 'ASC']);
        foreach ($categorie as $cat) {
            $cat->getSousCategories()->count(); 
        }

        $commande = $commandeRepository->createQueryBuilder('c')
            ->where('c.statu != :statu')
            ->setParameter('statu', 'Livrée')
            ->orderBy('c.dateCommande', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

                
            foreach ($commande as $cmd) {
                foreach ($cmd->getDetailCommandes() as $detail) {
                    $produit = $detail->getProduit(); 
                }
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

         if (!$this->isGranted('ROLE_COMMERCIAL') && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'avez pas les droits pour accéder à cette page.');
            return $this->redirectToRoute('app_accueil');
        }
        
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

        if (!$this->isGranted('ROLE_COMMERCIAL') && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'avez pas les droits pour accéder à cette page.');
            return $this->redirectToRoute('app_accueil');
        }
        
        $token = new CsrfToken('authenticate', $request->request->get('_csrf_token'));
        if (!$csrfTokenManager->isTokenValid($token)) {
            throw new \Exception('Jeton CSRF invalide.');
        }

        try {

            $action = $request->get('action');
            $id = $request->request->get('produit-select');
            $lib_court = $request->request->get('produit-libelle_court');
            $lib_long = $request->request->get('produit_libelle_long');
            $stock = $request->request->get('produit-stock');
            $prixHt = $request->request->get('produit-prixht');
            $prixFourni = $request->request->get('produit-prixFournisseur');
            $promotion = $request->request->get('produit-promotion');
            $fournisseurId = $request->request->get('produit-fourni');
            $souscatId = $request->request->get('produit-sous_categorie');
            $image = $request->files->get('produit-image');
            $active = $request->request->get('produit-active');


            // dd($request);

            if ($action === 'delete') {
                if (!$id) {
                    $this->addFlash('error', 'Aucun produit sélectionné.');
                    return $this->redirectToRoute('app_admin');
                }

                    $produit = $produitRepository->find($id);
                    if (!$produit) {
                        $this->addFlash('error', 'Produit introuvable.');
                        return $this->redirectToRoute('app_admin');
                }
                
                $entityManager->remove($produit);
                $entityManager->flush();

                $this->addFlash('success', 'Produit supprimé avec succès.');
                return $this->redirectToRoute('app_admin');
            }
            
            $errors = [];

        
            if (empty(trim($lib_court))) {
                $errors[] = 'Le nom du produit est obligatoire.';
            }
            
            if (empty(trim($lib_long))) {
                $errors[] = 'La description du produit est obligatoire.';
            }
            
            if (empty(trim($stock))) {
                    $errors[] = 'Le nombre de produits en stock est obligatoire.';
                } elseif (!ctype_digit($stock)) {
                        $errors[] = 'Le stock doit être un nombre entier positif.';
                    } else {
                        $stock = (int) $stock;
                }

            
            if (empty(trim($prixHt))) {
                $errors[] = 'Le prix hors taxe du produit est obligatoire.';
            }
            
            if (empty(trim($prixFourni))) {
                $errors[] = 'Le prix fournisseur du produit est obligatoire.';
            }
            
            if (empty(trim($fournisseurId))) {
                $errors[] = 'Le nom du fournisseur du produit est obligatoire.';
            }
            
            if (empty(trim($souscatId))) {
                $errors[] = 'La catégorie du produit est obligatoire.';
            }

            if (!empty(trim($promotion))) {
                if (is_numeric($promotion)) {
                    $promotion = ((int) $promotion) / 100;
                } else {
                    $errors[] = 'La promotion doit être un nombre entier.';
                }
            } else {
                $promotion = 0; 
            }

        
            if ($id) {
                $produit = $produitRepository->find($id);
                if (!$produit) {
                    throw $this->createNotFoundException('Produit introuvable.');
                }
            } else {
                $produit = new Produit();
            }

            
            if (!$id && !$image) {
                $errors[] = 'L\'image du produit est obligatoire.';
            }

            
            $fournisseur = $entityManager->getRepository(Fournisseur::class)->find($fournisseurId);
            $sousCategorie = $entityManager->getRepository(SousCategorie::class)->find(trim($souscatId));

           
            if (!$fournisseur) {
                $errors[] = 'Fournisseur introuvable.';
            }
            
            if (!$sousCategorie) {
                $errors[] = 'Sous-catégorie introuvable.';
            }


            $imagePath = null;

                if ($image) {
                    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    if (!in_array($image->getMimeType(), $allowedMimeTypes)) {
                        $errors[] = 'Le fichier doit être une image (JPEG, PNG, GIF ou WebP).';
                    }
                }

         if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->addFlash('error', $error);
            }
            return $this->redirectToRoute('app_admin');
        }

                if ($image) {
                $extension = $image->guessExtension();
                $cleanLibelleCourt = preg_replace('/[^a-zA-Z0-9_-]/', '_', trim($lib_court));
                $cleanLibelleCourt = preg_replace('/_+/', '_', $cleanLibelleCourt);
                $cleanLibelleCourt = trim($cleanLibelleCourt, '_');
                $timestamp = time();
                $newFilename = $cleanLibelleCourt . '_' . $timestamp . '.' . $extension;

                $uploadDir = $this->getParameter('kernel.project_dir') . '/public/image/produit/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                try {
                    if ($id && $produit->getImage()) {
                        $oldImagePath = $this->getParameter('kernel.project_dir') . '/public/' . $produit->getImage();
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }

                    $image->move($uploadDir, $newFilename);
                    $imagePath = 'image/produit/' . $newFilename;

                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors de l\'upload de l\'image.');
                    return $this->redirectToRoute('app_admin');
                }
            }


         
            $produit->setLibelleCourt(trim($lib_court));
            $produit->setLibelleLong(trim($lib_long));
            $produit->setStock(trim($stock));
            $produit->setPrixHt(trim($prixHt));
            $produit->setPrixFournisseur(trim($prixFourni));
            $produit->setPromotion($promotion);
            $produit->setFournisseur($fournisseur);
            $produit->setSousCategorie($sousCategorie); 
            $produit->setActive($active);
            
            if ($imagePath) {
                $produit->setImage($imagePath);
            } elseif (!$id) {
                $produit->setImage(null);
            }
            
            $entityManager->persist($produit);
            $entityManager->flush();

            $this->addFlash('success', 'Le produit a été ajouté ou mis à jour avec succès.');
            return $this->redirectToRoute('app_admin');
            
        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur s\'est produite, veuillez réessayer.');
            return $this->redirectToRoute('app_admin');
        }
    }



    #[Route('/admin-update-commande', name: 'app_admin_update_commande', methods: ['POST'])]
    public function adminUpdateCom(CsrfTokenManagerInterface $csrfTokenManager, Request $request, CommandeRepository $commandeRepository, DetailCommandeRepository $detailComRepo,  EntityManagerInterface $entityManager): Response
    {

         if (!$this->isGranted('ROLE_COMMERCIAL') && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'avez pas les droits pour accéder à cette page.');
            return $this->redirectToRoute('app_accueil');
        }
        
        $token = new CsrfToken('authenticate_commande', $request->request->get('_csrf_token'));
        if (!$csrfTokenManager->isTokenValid($token)) {
            throw new \Exception('Jeton CSRF invalide.');
        }

            $tabValue = ['en_attente', 'en_préparation', 'expédiée', 'livrée'];
            
            $id  = $request->request->get('com_id');
            $select = $request->request->get('statut');
            $commande = $commandeRepository->find($id);
            $detailCommande = $detailComRepo->findBy(['Commande' => $commande]);

            if (!$commande) {
                $this->addFlash('error', 'Commande introuvable.');
                return $this->redirectToRoute('app_admin');
            }

            if (!in_array($select, $tabValue, true)) {
                    $this->addFlash('error', 'Erreur dans le formulaire.');
                    return $this->redirectToRoute('app_admin');
                }
 
        try {

          foreach ($detailCommande as $key) {
            
            $key->setStatut($select);
            $entityManager->persist($key);
            $entityManager->flush();

          }
                $commande->setStatu($select);
                $entityManager->persist($commande);
                $entityManager->flush();

         } catch(\Exception $e) {
            $this->addFlash('error', 'Une erreur s\'est produite, veuillez réessayer.');
            return $this->redirectToRoute('app_admin');
         }
         
        return $this->redirectToRoute('app_admin');
        
    }

    // --------------------

        #[Route('/admin-update-det_com', name: 'app_admin_update_det_com', methods: ['POST'])]
    public function adminUpdateDetCom(CsrfTokenManagerInterface $csrfTokenManager, Request $request, CommandeRepository $commandeRepository, DetailCommandeRepository $detailComRepo,  EntityManagerInterface $entityManager): Response
    {

         if (!$this->isGranted('ROLE_COMMERCIAL') && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'avez pas les droits pour accéder à cette page.');
            return $this->redirectToRoute('app_accueil');
        }
        
        $token = new CsrfToken('update_detail_commande', $request->request->get('update_detail_commande'));
        if (!$csrfTokenManager->isTokenValid($token)) {
            throw new \Exception('Jeton CSRF invalide.');
        }

            $tabValue = ['en_attente', 'en_préparation', 'expédiée', 'livrée'];

            $id  = $request->request->get('com-commande-produit-id');
            $select = $request->request->get('statut-produit');
            $detCommande = $detailComRepo->find($id);
            
            $commande = $detCommande->getCommande();



            if (!$detCommande) {
                $this->addFlash('error', 'Commande introuvable.');
                return $this->redirectToRoute('app_admin');
            }

            if (!in_array($select, $tabValue, true)) {
                    $this->addFlash('error', 'Erreur dans le formulaire.');
                    return $this->redirectToRoute('app_admin');
                }
 
        try {

                $detCommande->setStatut($select);
                $entityManager->persist($detCommande);
                $entityManager->flush();

         } catch(\Exception $e) {
            $this->addFlash('error', 'Une erreur s\'est produite, veuillez réessayer.');
            return $this->redirectToRoute('app_admin');
         }
         
        return $this->redirectToRoute('app_admin');
        
    }


}