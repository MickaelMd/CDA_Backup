<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LegalController extends AbstractController
{
    #[Route('/apropos', name: 'app_apropos')]
    public function apropos(): Response
    {
        return $this->render('legal/apropos.html.twig', [
            'controller_name' => 'LegalController',
        ]);
    }

    #[Route('/mentionslegales', name: 'app_ml')]
    public function ml(): Response
    {
        return $this->render('legal/ml.html.twig', [
            'controller_name' => 'LegalController',
        ]);
    }
    #[Route('/politiquedeconfidentialite', name: 'app_pdc')]
    public function pdc(): Response
    {
        return $this->render('legal/pdc.html.twig', [
            'controller_name' => 'LegalController',
        ]);
        
    }

        #[Route('/cgv', name: 'app_cgv')]
    public function cgv(): Response
    {
        return $this->render('legal/cgv.html.twig', [
            'controller_name' => 'LegalController',
        ]);
    }
}