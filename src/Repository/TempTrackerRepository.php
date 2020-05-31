<?php

namespace App\Repository;

use App\Entity\TempTracker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TempTracker|null find($id, $lockMode = null, $lockVersion = null)
 * @method TempTracker|null findOneBy(array $criteria, array $orderBy = null)
 * @method TempTracker[]    findAll()
 * @method TempTracker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TempTrackerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TempTracker::class);
    }

    public function getHighest()
    {
        return $this->createQueryBuilder('t')
            ->select('MAX(t.temperature)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getLowest()
    {
        return $this->createQueryBuilder('t')
            ->select('MIN(t.temperature)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getAverage()
    {
        return $this->createQueryBuilder('t')
            ->select('AVG(t.temperature)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
