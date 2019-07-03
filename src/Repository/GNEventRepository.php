<?php

namespace App\Repository;

use App\Entity\GNEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GNEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method GNEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method GNEvent[]    findAll()
 * @method GNEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GNEventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GNEvent::class);
    }

    // /**
    //  * @return GNEvent[] Returns an array of GNEvent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GNEvent
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
