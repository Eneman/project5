<?php

namespace App\Repository;

use App\Entity\Stb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Stb|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stb|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stb[]    findAll()
 * @method Stb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StbRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Stb::class);
    }

    // /**
    //  * @return Stb[] Returns an array of Stb objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stb
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
