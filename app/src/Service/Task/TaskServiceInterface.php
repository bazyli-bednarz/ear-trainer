<?php

namespace App\Service\Task;

use App\Dto\Node\CreateNodeDto;
use App\Dto\Node\EditNodeDto;
use App\Dto\Task\CreateTaskDto;
use App\Dto\Task\CreateIntervalTaskDto;
use App\Dto\Task\CreateRelativePitchSoundTaskDto;
use App\Entity\Course;
use App\Entity\Enum\TaskTypeEnum;
use App\Entity\Node;
use App\Entity\Task\AbstractTask;

interface TaskServiceInterface
{
    public function getFirstTaskForNode(Node $node): ?AbstractTask;
    public function getLastTaskForNode(Node $node): ?AbstractTask;
    public function getTasksForNode(Node $node): array;

    public function getTasksForNodeExceptGiven(Node $node, AbstractTask $task): array;

    public function getById(int $id): ?AbstractTask;

    public function create(CreateTaskDto $dto, Node $node): AbstractTask;

//    public function update(AbstractTask $task, EditNodeDto $dto): AbstractTask;
//
//    public function delete(AbstractTask $task): void;
}