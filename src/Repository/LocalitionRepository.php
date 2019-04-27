<?php

namespace App\Repository;

use App\Entity\Localition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Localition|null find($id, $lockMode = null, $lockVersion = null)
 * @method Localition|null findOneBy(array $criteria, array $orderBy = null)
 * @method Localition[]    findAll()
 * @method Localition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocalitionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Localition::class);
    }

    // /**
    //  * @return Localition[] Returns an array of Localition objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Localition
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
