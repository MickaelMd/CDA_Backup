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
            $this->addFlash('error', 'Commande introuvable.');
            return $this->redirectToRoute('app_admin_pagination');
        }
        
        $commande->getDetailCommandes()->initialize();

        return $this->render('admin_pagination/commande.html.twig', [
           'commande' => $commande,
        ]);
    }

    #[Route('/admin/commande/updatedet', name: 'app_admin_commande_update_det', methods: ['POST'])]
public function adminUpdateDetCom(
    CsrfTokenManagerInterface $csrfTokenManager, 
    Request $request, 
    UpdateDetComService $updateDetComService
): Response {
    if (!$this->isGranted('ROLE_COMMERCIAL') && !$this->isGranted('ROLE_ADMIN')) {
        $this->addFlash('error', 'Vous n\'avez pas les droits pour accéder à cette page.');
        return $this->redirectToRoute('app_accueil');
    }
    
    $token = new CsrfToken('update_detail_commande', $request->request->get('update_detail_commande'));
    if (!$csrfTokenManager->isTokenValid($token)) {
        $this->addFlash('error', 'Jeton CSRF invalide.');
        return $this->redirectToRoute('app_admin');
    }

    $detailCommandeId = $request->request->get('com-commande-produit-id');
    $nouveauStatut = $request->request->get('statut-produit');
    $commandeId = (int) $request->request->get('com_id');



    try {
        
        $result = $updateDetComService->updateDetailCommandeById($detailCommandeId, $nouveauStatut);
        
        
        if ($result['success']) {
            $this->addFlash('success', $result['message']);
        } else {
            $this->addFlash('error', $result['message']);
        }

    } catch (\Exception $e) {
        $this->addFlash('error', 'Une erreur inattendue s\'est produite.');
    }


 return $this->redirectToRoute('app_admin_commande', [
        'id' => $commandeId
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