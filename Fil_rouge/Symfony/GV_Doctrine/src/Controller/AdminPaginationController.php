<?php

namespace App\Controller;

use App\Service\UpdateDetComService;
use App\Repository\CommandeRepository;
use App\Service\UpdateCommandeService;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\DetailCommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AdminPaginationController extends AbstractController
{
    #[Route('/admin/commande', name: 'app_admin_pagination')]
    public function index(
        PaginatorInterface $paginator,
        Request $request,
        CommandeRepository $commandeRepository
    ): Response {
        if (!$this->isGranted('ROLE_COMMERCIAL') && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'avez pas les droits pour accéder à cette page.');
            return $this->redirectToRoute('app_accueil');
        }

        $statu = $request->query->get('statu');

        $queryBuilder = $commandeRepository->createQueryBuilder('c');

        if ($statu && in_array($statu, ['en_attente', 'en_préparation', 'expédiée', 'livrée'])) {
            $queryBuilder->where('c.statu = :statu')
                         ->setParameter('statu', $statu);
        }

        $queryBuilder->orderBy('c.dateCommande', 'DESC');

        $pagination = $paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin_pagination/index.html.twig', [
            'pagination' => $pagination,
            'statu' => $statu,
        ]);
    }

    #[Route('/admin/commande/{id}', name: 'app_admin_commande', requirements: ['id' => '\d+'])]
    public function com(
        int $id,
        Request $request,
        CommandeRepository $commandeRepository
    ): Response {
        if (!$this->isGranted('ROLE_COMMERCIAL') && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'avez pas les droits pour accéder à cette page.');
            return $this->redirectToRoute('app_accueil');
        }

        $commande = $commandeRepository->find($id);
        
        if (!$commande) {
            throw $this->createNotFoundException('Commande non trouvée');
        }
        
        $commande->getDetailCommandes()->initialize();

        return $this->render('admin_pagination/commande.html.twig', [
           'commande' => $commande,
        ]);
    }

    #[Route('/admin/commande/updatedet', name: 'app_admin_commande_update_det', methods: ['POST'])]
    public function commandeUpdateDetCom(
        CsrfTokenManagerInterface $csrfTokenManager, 
        Request $request, 
        DetailCommandeRepository $detailComRepo,  
        UpdateDetComService $commandeService
    ): Response {
        if (!$this->isGranted('ROLE_COMMERCIAL') && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'avez pas les droits pour accéder à cette page.');
            return $this->redirectToRoute('app_accueil');
        }
        
        $token = new CsrfToken('update_detail_commande', $request->request->get('update_detail_commande'));
        if (!$csrfTokenManager->isTokenValid($token)) {
            throw new \Exception('Jeton CSRF invalide.');
        }

        $id = (int) $request->request->get('com-commande-produit-id');
        $select = $request->request->get('statut-produit');
        $detCommande = $detailComRepo->find($id);

        if (!$detCommande) {
            $this->addFlash('error', 'Commande introuvable.');
            return $this->redirectToRoute('app_admin_pagination');
        }

        try {
            $result = $commandeService->updateDetailCommande($detCommande, $select);

            if ($result === 'expédiée') {
                $this->addFlash('success', 'Statut mis à jour et email d\'expédition envoyé.');
            } else {
                $this->addFlash('success', 'Statut mis à jour avec succès.');
            }

        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
            return $this->redirectToRoute('app_admin_commande', [
                'id' => (int) $detCommande->getCommande()->getId()
            ]);
        }

        return $this->redirectToRoute('app_admin_commande', [
            'id' => (int) $detCommande->getCommande()->getId()
        ]);
    }

     #[Route('/admin/commande/updatecom', name: 'app_admin_commande_update_com', methods: ['POST'])]
    public function commandeUpdateCom(
       CsrfTokenManagerInterface $csrfTokenManager, 
        Request $request, 
        UpdateCommandeService $commandeUpdateService
    ): Response {
        if (!$this->isGranted('ROLE_COMMERCIAL') && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'avez pas les droits pour accéder à cette page.');
            return $this->redirectToRoute('app_accueil');
        }
        
        $token = new CsrfToken('authenticate_commande', $request->request->get('_csrf_token'));
        if (!$csrfTokenManager->isTokenValid($token)) {
            throw new \Exception('Jeton CSRF invalide.');
        }

        $commandeId = (int) $request->request->get('com_id');
        $newStatus = $request->request->get('statut');

    try {
        
        $result = $commandeUpdateService->updateCommandeStatus($commandeId, $newStatus);
        
        if ($result['success']) {
            $this->addFlash('success', $result['message']);
        } else {
            $this->addFlash('error', $result['message']);
        }
        
    } catch (\InvalidArgumentException $e) {
        $this->addFlash('error', 'Erreur dans le formulaire.');
    } catch (\Exception $e) {
        $this->addFlash('error', $e->getMessage());
    }

     return $this->redirectToRoute('app_admin_commande', [
    'id' => $commandeId
         ]);

    }


}