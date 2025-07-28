<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminPaginationController extends AbstractController
{
    #[Route('/admin/commande', name: 'app_admin_pagination')]
    public function index(): Response
    {

         if (!$this->isGranted('ROLE_COMMERCIAL') && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'avez pas les droits pour accéder à cette page.');
            return $this->redirectToRoute('app_accueil');
        }


        return $this->render('admin_pagination/index.html.twig', [
            'controller_name' => 'AdminPaginationController',
        ]);
    }
}