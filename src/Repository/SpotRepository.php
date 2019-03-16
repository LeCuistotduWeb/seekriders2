<?php

namespace App\Repository;

use App\Entity\Spot;
use App\Entity\SpotSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Spot|null find($id, $lockMode = null, $lockVersion = null)
 * @method Spot|null findOneBy(array $criteria, array $orderBy = null)
 * @method Spot[]    findAll()
 * @method Spot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpotRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Spot::class);
    }

    public function findByTitle(SpotSearch $search): Query
    {
        $query = $this->createQueryBuilder('s');

        if($search->getTitle()){
            $query = $query
                ->andWhere('s.title = :title')
                ->setParameter('title', $search->getTitle());
        }

        if($search->getType()){
            $query = $query
                ->andWhere('s.type = :type')
                ->setParameter('type', $search->getType());
        }

        return $query->getQuery();
    }

    // /**
    //  * @return Spot[] Returns an array of Spot objects
    //  */
    public function findLastSpotsCreatedWidthLimit($value)
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.createdAt', 'DESC')
            ->setMaxResults($value)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Spot[] Returns an array of Spot objects
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
    public function findOneBySomeField($value): ?Spot
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
