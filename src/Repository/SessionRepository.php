<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Session::class);
    }

    // /**
    //  * @return Sessions[] Returns an array of Sessions objects
    //  */
    public function findLastSessionsCreatedWidthLimit($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.startDateAt >= :today')
            ->setParameter('today', new \Datetime())
            ->orderBy('s.startDateAt', 'ASC')
            ->setMaxResults($value)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Sessions[] Returns an array of Sessions objects
    //  */
    public function findSessionsNotDone()
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.startDateAt >= :today')
            ->setParameter('today', new \Datetime())
            ->orderBy('s.startDateAt', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Session[] Returns an array of Session objects
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
    public function findOneBySomeField($value): ?Session
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
