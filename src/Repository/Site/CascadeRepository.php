<?php

namespace App\Repository\Site;

use App\Entity\Site\Cascade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Cascade|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cascade|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cascade[]    findAll()
 * @method Cascade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CascadeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cascade::class);
    }

    // /**
    //  * @return Cascade[] Returns an array of Cascade objects
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
    public function findOneBySomeField($value): ?Cascade
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
