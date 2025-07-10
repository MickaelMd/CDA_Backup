<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CommandeRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class DetailCommandeController extends AbstractController
{
    #[Route('/commande/{id}', name: 'app_detail_commande', methods: ['GET', 'POST'])]
    public function index(
        int $id,
        Request $request, 
        CommandeRepository $commandeRepository,
        CsrfTokenManagerInterface $csrfTokenManager
    ): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $this->addFlash('error', 'Vous devez être <a href="/connexion">connecté</a> pour accéder à votre commande.');
            return $this->redirectToRoute('app_accueil');
        }

        /** @var \App\Entity\Utilisateur $user */
        $user = $this->getUser();


        $commande = $commandeRepository->find($id);

        if (!$commande) {
            $this->addFlash('error', 'Vous n\'avez pas accès à cette commande.');
            return $this->redirectToRoute('app_accueil');
        }

        if ($commande->getClient() !== $user) {
            $this->addFlash('error', 'Vous n\'avez pas accès à cette commande.');
            return $this->redirectToRoute('app_accueil');
        }

             if ($request->isMethod('POST')) {

                try {

            $token = new CsrfToken('authenticate', $request->request->get('_csrf_token'));
            if (!$csrfTokenManager->isTokenValid($token)) {
                throw new \Exception('Jeton CSRF invalide.');
            }
                

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

                return new Response(
                    $output,
                    200,
                    [
                        'Content-Type' => 'application/pdf',
                    ]
                );
            
              } catch (\Exception $e) {
                    $this->addFlash('error', 'Une erreur s\'est produite, veuillez réessayer.');
                    return $this->redirectToRoute('app_detail_commande', ['id' => $commande->getId()]);
               }

        }

        return $this->render('detail_commande/index.html.twig', [
            'commande' => $commande,
            'controller_name' => 'DetailCommandeController',
        ]);
    }
}