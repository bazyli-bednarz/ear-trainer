<?php

namespace App\Repository\Statistic;

use App\Entity\Statistic\ExperienceStatistic;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExperienceStatistic>
 */
class ExperienceStatisticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExperienceStatistic::class);
    }


    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getExperienceByUser(User $user): int
    {
        return $this->createQueryBuilder('es')
            ->select('SUM(es.points)')
            ->andWhere('es.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult() ?? 0;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getExperienceInRange(User $user, DateTimeImmutable $start, DateTimeImmutable $end): int
    {
        return $this->createQueryBuilder('es')
            ->select('SUM(es.points)')
            ->andWhere('es.user = :user')
            ->setParameter('user', $user)
            ->andWhere('es.createdAt >= :start')
            ->setParameter('start', $start)
            ->andWhere('es.createdAt <= :end')
            ->setParameter('end', $end)
            ->getQuery()
            ->getSingleScalarResult() ?? 0;
    }
}
