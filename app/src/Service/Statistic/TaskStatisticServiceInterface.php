<?php

namespace App\Service\Statistic;

use App\Entity\Node;
use App\Entity\Statistic\TaskStatistic;
use App\Entity\Task\AbstractTask;
use App\Entity\User;

interface TaskStatisticServiceInterface
{

    public function getTaskStatisticsByUser(User $user, int $taskId): array;
    public function countTaskStatisticsByUser(User $user): int;
    public function addStatistic(User $user, AbstractTask $task): TaskStatistic;
    public function determinePoints(User $user, AbstractTask $task): int;

    public function isTaskCompletedByUser(User $user, AbstractTask $task): bool;

    public function getCompletedTasksCountForNode(Node $node, User $user): int;
}