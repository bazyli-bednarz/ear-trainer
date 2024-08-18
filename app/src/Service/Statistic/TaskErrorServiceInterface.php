<?php

namespace App\Service\Statistic;

use App\Entity\Node;
use App\Entity\Statistic\TaskError;
use App\Entity\Statistic\TaskStatistic;
use App\Entity\Task\AbstractTask;
use App\Entity\User;
use DateTimeImmutable;

interface TaskErrorServiceInterface
{

    public function getTaskErrorsByUser(User $user): array;
    public function addTaskError(User $user, int $taskId): ?TaskError;

    public function getTaskError(AbstractTask $task, User $user): ?TaskError;
    public function delete(TaskError $taskError): void;
}