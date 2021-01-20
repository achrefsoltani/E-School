<?php

namespace App\Repository;

use App\Entity\Contacte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contacte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contacte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contacte[]    findAll()
 * @method Contacte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContacteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contacte::class);
    }

    // /**
    //  * @return Contacte[] Returns an array of Contacte objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Contacte
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
