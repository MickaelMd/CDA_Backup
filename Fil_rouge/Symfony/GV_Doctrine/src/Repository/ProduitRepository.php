<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    //    /**
    //     * @return Produit[] Returns an array of Produit objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Produit
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

public function produitpopulaire(int $limit = 5): array
{
    $entityManager = $this->getEntityManager();

    $qb = $entityManager->createQueryBuilder();
    $qb->select('p')
        ->from('App\Entity\Produit', 'p')
        ->join('p.detailCommandes', 'dc')
        ->where('p.active = 1')
        ->groupBy('p.id')
        ->orderBy('SUM(dc.quantite)', 'DESC')
        ->setMaxResults($limit);

    $popularProducts = $qb->getQuery()->getResult();

    $count = count($popularProducts);
    if ($count < $limit) {
        $qb2 = $entityManager->createQueryBuilder();
        $qb2->select('p')
            ->from('App\Entity\Produit', 'p')
            ->where('p.active = 1');
        if ($count > 0) {
            $excludedIds = array_map(fn($p) => $p->getId(), $popularProducts);
            $qb2->andWhere($qb2->expr()->notIn('p.id', ':excluded'))
                ->setParameter('excluded', $excludedIds);
        }

        $qb2->orderBy('p.libelleCourt', 'ASC')
            ->setMaxResults($limit - $count);

        $additionalProducts = $qb2->getQuery()->getResult();
        $popularProducts = array_merge($popularProducts, $additionalProducts);
    }

    return $popularProducts;
}

public function ProduitSimilaire($sousCategorie, $excludeId, $limit = null)
{
    $qb = $this->createQueryBuilder('p')
        ->where('p.active = :active')
        ->andWhere('p.sousCategorie = :sousCategorie')
        ->andWhere('p.id != :excludeId')
        ->setParameter('active', 1)
        ->setParameter('sousCategorie', $sousCategorie)
        ->setParameter('excludeId', $excludeId);
    
    if ($limit) {
        $qb->setMaxResults($limit);
    }
    
    return $qb->getQuery()->getResult();
}

}