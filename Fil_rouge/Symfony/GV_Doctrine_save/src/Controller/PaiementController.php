<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\DetailCommande;
use App\Entity\Utilisateur;
use App\Repository\ProduitRepository;
use App\Service\PanierService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;



final class PaiementController extends AbstractController
{
    #[Route('/paiement', name: 'app_paiement')]
    public function index(PanierService $panierService, ProduitRepository $produitRepository): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $this->addFlash('error', 'Vous devez être <a href="/connexion">connecté</a> pour valider votre commande.');
            return $this->redirectToRoute('app_login');
        }

        $panier = $panierService->getPanier(); 

        if (empty($panier)) {
            $this->addFlash('error', 'Votre panier est vide.');
            return $this->redirectToRoute('app_accueil');
        }

        $user = $this->getUser();
        $detailsPanier = [];
        $totalPanier = 0;
        
        if (!$user instanceof Utilisateur) {
            $coefficient = 1.2; 
        } else {
            $coefficient = (float) $user->getCoefficient();
        }
        
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

        return $this->render('paiement/index.html.twig', [
            'controller_name' => 'PaiementController',
            'detailsPanier' => $detailsPanier,
            'totalPanier' => $totalPanier,
            'nombreArticles' => array_sum($panier)
        ]);
    }

    #[Route('/paiement/valider', name: 'app_paiement_valider', methods: ['POST'])]
    public function validerCommande(
        Request $request,
        PanierService $panierService,
        ProduitRepository $produitRepository,
        EntityManagerInterface $entityManager,
        CsrfTokenManagerInterface $csrfTokenManager,
        MailerInterface $mailer
    ): Response {
      
        if (!$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $this->addFlash('error', 'Vous devez être connecté pour valider votre commande.');
            return $this->redirectToRoute('app_panier');
        }

        $panier = $panierService->getPanier();
        if (empty($panier)) {
            $this->addFlash('error', 'Votre panier est vide.');
            return $this->redirectToRoute('app_accueil');
        }

        $token = new CsrfToken('authenticate', $request->request->get('_token'));
        if (!$csrfTokenManager->isTokenValid($token)) {
            throw new \Exception('Jeton CSRF invalide.');
        }

        if ($request->request->get('cgv') == false) {
            $this->addFlash('error', 'Vous devez acepter les conditions général de vente');
            return $this->redirectToRoute('app_paiement');
        }

        /** @var \App\Entity\Utilisateur $user */
        $user = $this->getUser();
   
        if ($user->getAdresseLivraison() == "") {
            $this->addFlash('error', 'Vous devez avoir une adresse de livraison pour valider votre commande.');
            return $this->redirectToRoute('app_paiement');
        }

            try {
            $commande = $this->creerCommande();
            $this->ajouterDetailsCommande($commande, $panier, $produitRepository);
            $this->sauvegarderCommande($commande, $entityManager);

            // ---------------- PDF FACTURE ---------------------

            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');

            $dompdf = new Dompdf($pdfOptions);

            $html = $this->renderView('dompdf/facture.html.twig', [
                'commande' => $commande,
            ]);

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $output = $dompdf->output(); 

            $filename = sprintf('facture-green-village-%d.pdf', $commande->getId());

            // ---------------- MAIL ---------------------

            $email = (new TemplatedEmail())
                ->from(new Address('noreply@greenvillage.com', 'Green Village'))
                ->to((string) $user->getEmail())
                ->subject('Green Village - Votre commande # ' . $commande->getId())
                ->htmlTemplate('mail/paiement_mail.html.twig')
                ->context([
                    'commande' => $commande,
                ])
                ->attach($output, $filename, 'application/pdf');

            $mailer->send($email);

            // ------------------------------------- 

            $panierService->viderPanier();

            
            $this->addFlash('success', 'Commande validée');
            return $this->redirectToRoute('app_paiement_valide');

        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur c\'est produite veuillez réessayer');
            return $this->redirectToRoute('app_paiement');
        }

    }

     // ------------------------------------- Fonction

    private function creerCommande(): Commande
    {
        $user = $this->getUser();
        
        if (!$user instanceof Utilisateur) {
            throw new \RuntimeException('L\'utilisateur doit être connecté');
        }
        
        $commande = new Commande();
        
        $commande->setDateCommande(new \DateTimeImmutable());
        $commande->setModePaiement('carte'); 
        $commande->setStatu('en_attente');
        $commande->setClient($user);
        
        if ($user->getCommercial() !== null) {
            $commande->setCommercial($user->getCommercial());
        }
        
        $commande->setAdresseLivraison($user->getAdresseLivraison() ?? '');
        $commande->setAdresseFacturation($user->getAdresseFacturation() ?? $user->getAdresseLivraison() ?? '');
        
        $commande->setTva($user->getCoefficient());
        
        return $commande;
    }


private function ajouterDetailsCommande(Commande $commande, array $panier, ProduitRepository $produitRepository): void
{
    /** @var \App\Entity\Utilisateur $user */
    $user = $this->getUser();
    
    $coefficient = 1.2; 
    if ($user instanceof Utilisateur && $user->getCoefficient() !== null) {
        $coefficient = (float) $user->getCoefficient();
    }
    
    $totalHT = 0;
    $totalTTC = 0;
    
   foreach ($panier as $produitId => $quantite) {
    $produit = $produitRepository->find($produitId);

    if ($produit) {
        $detailCommande = new DetailCommande();
        $detailCommande->setProduit($produit);
        $detailCommande->setQuantite($quantite);

        $prixHT = $produit->getPrixHt();
        $prixBase = $prixHT * $coefficient;

        if ($produit->getPromotion() !== null && $produit->getPromotion() > 0) {
            $prixTTC = $prixBase * (1 - $produit->getPromotion());
        } else {
            $prixTTC = $prixBase;
        }

        $detailCommande->setPrix((string) $prixTTC);
        $detailCommande->setPromotion($produit->getPromotion());

        $detailCommande->setCommande($commande);
        $commande->addDetailCommande($detailCommande);

        $totalHT += $prixHT * $quantite;
        $totalTTC += $prixTTC * $quantite;
    }
}

    

    $commande->setTotalHt((string) $totalHT);
    $commande->setTotal((string) $totalTTC);
}

    private function sauvegarderCommande(Commande $commande, EntityManagerInterface $entityManager): void
    {
        $entityManager->persist($commande);
        
        foreach ($commande->getDetailCommandes() as $detailCommande) {
            $entityManager->persist($detailCommande);
        }
        
        $entityManager->flush();
    }


#[Route('/paiement/valide/', name: 'app_paiement_valide')]
public function confirmation(): Response
{
    return $this->render('paiement/valide.html.twig');
}

}