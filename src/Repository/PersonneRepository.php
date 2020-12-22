<?php

namespace App\Repository;

use App\Entity\Personne;
use App\Entity\Seance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Personne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personne[]    findAll()
 * @method Personne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personne::class);
    }

    // /**
    //  * @return Personne[] Returns an array of Personne objects
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
    public function findOneBySomeField($value): ?Personne
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */



    public function createchoiceEleveQueryBuilder(int $niv)
    {
        return $this->createQueryBuilder('personne')
            ->addSelect('c')
            ->leftJoin('personne.classe','c')
            ->where("personne.role = 'eleve' and personne.niveau = :i and c is null" )
            ->orderBy('personne.nom', 'ASC')
            ->setParameter('i', $niv);
    }

    public function createchoiceEnseignatQueryBuilder()
    {
        return $this->createQueryBuilder('personne')
            ->where("personne.role = 'enseignant'")
            ->orderBy('personne.nom', 'ASC');

    }
    public function absenceeleve()
    {
        return $this->createQueryBuilder('personne')
            ->addSelect('p')
            ->leftJoin('personne.absences','s')
            ->where("personne.role = 'eleve' and s.seance = :i")
            ->orderBy('personne.nom', 'ASC');
            //->setParameter('i', $seance);
    }
}
