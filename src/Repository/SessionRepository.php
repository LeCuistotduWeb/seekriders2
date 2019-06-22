<?php

namespace App\Repository;

use App\Entity\Session;
use App\Entity\SessionSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
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
    //  *
    //  */
    public function findSessionsWidthOptions(SessionSearch $search): Query
    {
        $query = $this->createQueryBuilder('s');

        if($search->getStartDateAt()){
            $query = $query
                ->andWhere('s.startDateAt >= :startDate')
                ->andWhere('s.startDateAt >= :today')
                ->setParameter('startDate', $search->getStartDateAt())
                ->setParameter('today', new \DateTime());
        }

        if($search->getEndDateAt()){
            $query = $query
                ->andWhere('s.endDateAt >= :startDate')
                ->setParameter('startDate', $search->getStartDateAt());
        }

        $query->orderBy('s.endDateAt', 'ASC');

        return $query->getQuery();
    }
}
