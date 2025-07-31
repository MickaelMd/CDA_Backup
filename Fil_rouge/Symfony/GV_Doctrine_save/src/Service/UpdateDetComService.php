<?php 

namespace App\Service;

use App\Entity\DetailCommande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class UpdateDetComService
{
    private const VALID_STATUSES = ['en_attente', 'en_préparation', 'expédiée', 'livrée'];
    
    private $entityManager;
    private $mailer;

    public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    /**
     * @param DetailCommande
     * @param string 
     * @return string 
     * @throws \InvalidArgumentException 
     * @throws \Exception 
     */
    public function updateDetailCommande(
        DetailCommande $detCommande,
        string $nouveauStatut
    ): string {
        // Validation du statut
        if (!$this->isValidStatus($nouveauStatut)) {
            throw new \InvalidArgumentException('Statut invalide fourni : ' . $nouveauStatut);
        }

        if (!$detCommande) {
            throw new \InvalidArgumentException('Détail de commande invalide.');
        }

        $commande = $detCommande->getCommande();
        if (!$commande) {
            throw new \Exception('Commande associée introuvable.');
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

            if ($ancienStatutCommande !== 'expédiée' && $nouveauStatutCommande === 'expédiée') {
                $this->sendShippingEmail($commande);
                return 'expédiée';
            }

            return 'mise_a_jour';

        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw new \Exception('Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    /**
     * @param string 
     * @return bool 
     */
    private function isValidStatus(string $status): bool
    {
        return in_array($status, self::VALID_STATUSES, true);
    }

    /**
     * @param \App\Entity\Commande 
     * @return string 
     */
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

    /**
     * @param \App\Entity\Commande 
     * @return bool
     */
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

    /**
     * @return array 
     */
    public function getValidStatuses(): array
    {
        return self::VALID_STATUSES;
    }
}