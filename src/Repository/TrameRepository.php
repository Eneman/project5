<?php

namespace App\Repository;

use App\Entity\Trame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Trame|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trame|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trame[]    findAll()
 * @method Trame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrameRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Trame::class);
    }

    // /**
    //  * @return Trame[] Returns an array of Trame objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Trame
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
