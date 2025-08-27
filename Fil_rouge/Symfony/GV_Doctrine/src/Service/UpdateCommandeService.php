<?php 

namespace App\Service;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Repository\DetailCommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class UpdateCommandeService
{
 private const VALID_STATUSES = ['en_attente', 'en_préparation', 'expédiée', 'livrée'];
    
    public function __construct(
        private CommandeRepository $commandeRepository,
        private DetailCommandeRepository $detailCommandeRepository,
        private EntityManagerInterface $entityManager,
        private MailerInterface $mailer
    ) {}

    /**
     * @param int 
     * @param string 
     * @return array 
     * @throws \InvalidArgumentException 
     * @throws \Exception 
     */
    public function updateCommandeStatus(int $commandeId, string $newStatus): array
    {
        if (!$this->isValidStatus($newStatus)) {
            throw new \InvalidArgumentException('Statut invalide fourni.');
        }

        
        $commande = $this->commandeRepository->find($commandeId);
        if (!$commande) {
            throw new \Exception('Commande introuvable.');
        }

        try {
          
            $this->updateDetailCommandeStatus($commande, $newStatus);
            
            $commande->setStatu($newStatus);
            $this->entityManager->persist($commande);
            $this->entityManager->flush();

            $emailSent = false;
            if ($newStatus === 'expédiée') {
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
    private function updateDetailCommandeStatus(Commande $commande, string $newStatus): void
    {
        $detailCommandes = $this->detailCommandeRepository->findBy(['Commande' => $commande]);
        
        foreach ($detailCommandes as $detailCommande) {
            $detailCommande->setStatut($newStatus);
            $this->entityManager->persist($detailCommande);
        }
        
        $this->entityManager->flush();
    }

    private function sendShippingEmail(Commande $commande): bool
    {
        try {
            $client = $commande->getClient();
            
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