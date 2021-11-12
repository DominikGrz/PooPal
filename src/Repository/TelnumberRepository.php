<?php

namespace App\Repository;

use App\Entity\Telnumber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Telnumber|null find($id, $lockMode = null, $lockVersion = null)
 * @method Telnumber|null findOneBy(array $criteria, array $orderBy = null)
 * @method Telnumber[]    findAll()
 * @method Telnumber[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TelnumberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Telnumber::class);
    }

    // /**
    //  * @return Telnumber[] Returns an array of Telnumber objects
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
    public function findOneBySomeField($value): ?Telnumber
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
