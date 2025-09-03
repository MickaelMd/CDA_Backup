<?php 

namespace App\Service;

use App\Entity\DetailCommande;
use App\Repository\DetailCommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class UpdateDetComService
{
    private const VALID_STATUSES = ['en_attente', 'en_préparation', 'expédiée', 'livrée'];
    
    public function __construct(
        private EntityManagerInterface $entityManager,
        private MailerInterface $mailer,
        private DetailCommandeRepository $detailCommandeRepository
    ) {}

    /**
     * @param int|string $detailCommandeId
     * @param string $nouveauStatut
     * @return array
     */
    public function updateDetailCommandeById($detailCommandeId, string $nouveauStatut): array
    {
        if (!$detailCommandeId) {
            return [
                'success' => false,
                'message' => 'ID du détail de commande manquant.'
            ];
        }

        if (!$nouveauStatut) {
            return [
                'success' => false,
                'message' => 'Statut manquant.'
            ];
        }

        if (!$this->isValidStatus($nouveauStatut)) {
            return [
                'success' => false,
                'message' => 'Statut invalide fourni.'
            ];
        }

        $detCommande = $this->detailCommandeRepository->find($detailCommandeId);
        if (!$detCommande) {
            return [
                'success' => false,
                'message' => 'Détail de commande introuvable.'
            ];
        }

        return $this->updateDetailCommande($detCommande, $nouveauStatut);
    }

    /**
     * @param DetailCommande $detCommande
     * @param string $nouveauStatut
     * @return array
     */
    public function updateDetailCommande(
        DetailCommande $detCommande,
        string $nouveauStatut
    ): array {
        
        if (!$this->isValidStatus($nouveauStatut)) {
            return [
                'success' => false,
                'message' => 'Statut invalide fourni.'
            ];
        }

        if (!$detCommande) {
            return [
                'success' => false,
                'message' => 'Détail de commande invalide.'
            ];
        }

        $commande = $detCommande->getCommande();
        if (!$commande) {
            return [
                'success' => false,
                'message' => 'Commande associée introuvable.'
            ];
        }

        
        if ($detCommande->getStatut() === $nouveauStatut) {
            return [
                'success' => false,
                'message' => 'Une erreur s\'est produite : Statut identique'
            ];
        }

        try {
            $this->entityManager->beginTransaction();

            $ancienStatutCommande = $commande->getStatu();
            $detCommande->setStatut($nouveauStatut);

            $nouveauStatutCommande = $this->calculateCommandeStatus($commande);
            $commande->setStatu($nouveauStatutCommande);

            $this->entityManager->persist($detCommande);
            $this->entityManager->persist($commande);
            $this->entityManager->flush();
            $this->entityManager->commit();

            $emailSent = false;
            if ($ancienStatutCommande !== 'expédiée' && $nouveauStatutCommande === 'expédiée') {
                $emailSent = $this->sendShippingEmail($commande);
            }

            $message = $emailSent 
                ? 'Statut mis à jour et email d\'expédition envoyé.'
                : 'Statut mis à jour avec succès.';

            return [
                'success' => true,
                'message' => $message
            ];

        } catch (\Exception $e) {
            $this->entityManager->rollback();
            
            return [
                'success' => false,
                'message' => 'Une erreur s\'est produite lors de la mise à jour : ' . $e->getMessage()
            ];
        }
    }


    private function isValidStatus(string $status): bool
    {
        return in_array($status, self::VALID_STATUSES, true);
    }


    private function calculateCommandeStatus($commande): string
    {
        $allLivree = true;
        $hasExpediee = false;
        $hasEnPreparation = false;

        foreach ($commande->getDetailCommandes() as $detail) {
            $statutDetail = $detail->getStatut();
            
            if ($statutDetail === 'expédiée') {
                $hasExpediee = true;
            }
            if ($statutDetail === 'en_préparation') {
                $hasEnPreparation = true;
            }
            if ($statutDetail !== 'livrée') {
                $allLivree = false;
            }
        }

        if ($allLivree) {
            return 'livrée';
        } elseif ($hasExpediee) {
            return 'expédiée';
        } elseif ($hasEnPreparation) {
            return 'en_préparation';
        } else {
            return 'en_attente';
        }
    }


    private function sendShippingEmail($commande): bool
    {
        try {
            $client = $commande->getClient();
            
            if (!$client || !$client->getEmail()) {
                return false;
            }

            $email = (new TemplatedEmail())
                ->from(new Address('noreply@greenvillage.com', 'Green Village'))
                ->to($client->getEmail())
                ->subject('Green Village - Votre commande #' . $commande->getId() . ' a été expédiée')
                ->htmlTemplate('mail/livraison_mail.html.twig')
                ->context([
                    'commande' => $commande,
                    'client' => $client,
                ]);

            $this->mailer->send($email);
            return true;

        } catch (\Exception $e) {
            return false;
        }
    }


    public function getValidStatuses(): array
    {
        return self::VALID_STATUSES;
    }
}