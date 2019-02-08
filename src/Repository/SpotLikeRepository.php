<?php

namespace App\Repository;

use App\Entity\SpotLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SpotLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpotLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpotLike[]    findAll()
 * @method SpotLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpotLikeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SpotLike::class);
    }

    // /**
    //  * @return SpotLike[] Returns an array of SpotLike objects
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
    public function findOneBySomeField($value): ?SpotLike
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
