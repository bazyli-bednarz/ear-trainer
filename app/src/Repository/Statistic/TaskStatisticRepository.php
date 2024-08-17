<?php

namespace App\Repository\Statistic;

use App\Entity\Statistic\TaskStatistic;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TaskStatistic>
 */
class TaskStatisticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskStatistic::class);
    }

    public function getTaskStatisticsByUser(User $user, int $taskId): array
    {
        return $this->createQueryBuilder('ts')
            ->addSelect('ts')
            ->addSelect('partial user.{id, email, username}')
            ->leftJoin('ts.user', 'user')
            ->andWhere('ts.taskId = :taskId')
            ->setParameter('taskId', $taskId)
            ->andWhere('ts.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
