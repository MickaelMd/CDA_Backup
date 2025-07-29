<?php 

namespace App\Service;

use App\Entity\DetailCommande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class UpdateDetComService
{
    private $entityManager;
    private $mailer;

    public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    public function updateDetailCommande(
        DetailCommande $detCommande,
        string $nouveauStatut
    ): string {
        $commande = $detCommande->getCommande();

        $ancienStatutCommande = $commande->getStatu();
        $detCommande->setStatut($nouveauStatut);

        $allLivree = true;
        $hasExpediee = false;
        foreach ($commande->getDetailCommandes() as $detail) {
            if ($detail->getStatut() === 'expédiée') {
                $hasExpediee = true;
            }
            if ($detail->getStatut() !== 'livrée') {
                $allLivree = false;
            }
        }

        if ($allLivree) {
            $nouveauStatutCommande = 'livrée';
        } elseif ($hasExpediee) {
            $nouveauStatutCommande = 'expédiée';
        } else {
            $nouveauStatutCommande = 'en_attente';
        }

        $commande->setStatu($nouveauStatutCommande);

        $this->entityManager->persist($detCommande);
        $this->entityManager->flush();

        if ($ancienStatutCommande !== 'expédiée' && $nouveauStatutCommande === 'expédiée') {
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

            return 'expédiée';
        }

        return 'mise_a_jour';
    }
}