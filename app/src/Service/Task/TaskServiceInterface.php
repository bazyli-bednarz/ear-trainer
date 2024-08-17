<?php

namespace App\Service\Task;


use App\Dto\Task\TaskDto;
use App\Entity\Node;
use App\Entity\Task\AbstractTask;
use App\Entity\User;

interface TaskServiceInterface
{
    public function getFirstTaskForNode(Node $node): ?AbstractTask;
    public function getLastTaskForNode(Node $node): ?AbstractTask;
    public function getTasksForNode(Node $node): array;
    public function getTasksForNodeWithUserInfo(Node $node, User $user): array;

    public function getTasksForNodeExceptGiven(Node $node, AbstractTask $task): array;

    public function getById(int $id): ?AbstractTask;

    public function create(TaskDto $dto, Node $node): AbstractTask;

    public function update(AbstractTask $task, TaskDto $dto): AbstractTask;

    public function delete(AbstractTask $task): void;
}