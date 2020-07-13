<?php

namespace App\Repository;

use App\Entity\PrductType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PrductType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrductType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrductType[]    findAll()
 * @method PrductType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrductTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrductType::class);
    }

    // /**
    //  * @return PrductType[] Returns an array of PrductType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PrductType
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
