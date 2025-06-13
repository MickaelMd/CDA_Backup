<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Utilisateur>
 */
class UtilisateurRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Utilisateur) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * Récupère un commercial aléatoire
     */
    public function findRandomCommercial(): ?Utilisateur
    {
        // Récupère tous les commerciaux
        $commerciaux = $this->createQueryBuilder('u')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%"ROLE_COMMERCIAL"%')
            ->getQuery()
            ->getResult();

        if (empty($commerciaux)) {
            return null;
        }

        // Sélectionne un commercial aléatoire avec PHP
        $randomIndex = array_rand($commerciaux);
        return $commerciaux[$randomIndex];
    }

    /**
     * Alternative avec une requête SQL native si vous préférez
     */
    public function findRandomCommercialNative(): ?Utilisateur
    {
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT id FROM utilisateur WHERE roles LIKE :role ORDER BY RAND() LIMIT 1";
        $stmt = $conn->executeQuery($sql, ['role' => '%"ROLE_COMMERCIAL"%']);
        $result = $stmt->fetchAssociative();
        
        if (!$result) {
            return null;
        }
        
        return $this->find($result['id']);
    }
}