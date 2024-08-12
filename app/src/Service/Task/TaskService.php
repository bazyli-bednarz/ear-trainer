<?php

namespace App\Service\Task;

use App\Dto\Task\TaskDto;
use App\Dto\Task\CreateIntervalTaskDto;
use App\Dto\Task\CreateRelativePitchSoundTaskDto;
use App\Entity\Course;
use App\Entity\Enum\TaskTypeEnum;
use App\Entity\Node;
use App\Entity\Task\AbstractTask;
use App\Entity\Task\Interval;
use App\Entity\Task\RelativePitchSound;
use App\Repository\AbstractTaskRepository;
use App\Repository\IntervalRepository;
use App\Repository\NodeRepository;
use App\Dto\Node\CreateNodeDto;
use App\Dto\Node\EditNodeDto;
use App\Repository\RelativePitchSoundRepository;
use App\Service\Node\NodeServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class TaskService implements TaskServiceInterface
{
    public function __construct(
        private readonly AbstractTaskRepository       $abstractTaskRepository,
        private readonly RelativePitchSoundRepository $relativePitchSoundRepository,
        private readonly IntervalRepository           $intervalRepository,
        private readonly EntityManagerInterface       $em,
    )
    {
    }

    public function getFirstTaskForNode(Node $node): ?AbstractTask
    {
        return $this->abstractTaskRepository->findOneBy(['node' => $node, 'previousTask' => null]);
    }

    public function getLastTaskForNode(Node $node): ?AbstractTask
    {
        return $this->abstractTaskRepository->findOneBy(['node' => $node, 'nextTask' => null]);
    }

    public function getTasksForNode(Node $node): array
    {
        $firstTask = $this->getFirstTaskForNode($node);
        $tasks = [];
        $currentTask = $firstTask;
        while ($currentTask !== null) {
            $tasks[] = $currentTask;
            $currentTask = $currentTask->getNextTask();
        }

        return $tasks;
    }


    public function getTasksForNodeExceptGiven(Node $node, AbstractTask $task): array
    {
        $firstTask = $this->getFirstTaskForNode($node);
        $tasks = [];
        $currentTask = $firstTask;
        while ($currentTask !== null) {
            if ($currentTask->getId() !== $task->getId()) {
                $tasks[] = $currentTask;
            }
            $currentTask = $currentTask->getNextTask();
        }

        return $tasks;
    }

    public function getById(int $id): ?AbstractTask
    {
        return $this->abstractTaskRepository->find($id);
    }

    public function create(TaskDto $dto, Node $node): AbstractTask
    {
        $task = match ($dto->getType()) {
            TaskTypeEnum::RelativePitchSound => $this->createRelativePitchSound($dto),
            TaskTypeEnum::Interval => $this->createInterval($dto),
            default => throw new \InvalidArgumentException('Invalid task type')
        };


        $previousTask = $dto->getPreviousTask();

        $task
            ->setName($dto->getName())
            ->setDescription($dto->getDescription())
            ->setPoints($dto->getPoints())
            ->setNode($node);

        if ($previousTask) {
            $nextTask = $previousTask->getNextTask();
            $nextTask?->setPreviousTask($task);
            $task->setPreviousTask($previousTask);
        } else {
            $firstTask = $this->getFirstTaskForNode($node);
            if ($firstTask !== $task) {
                $firstTask?->setPreviousTask($task);
            }
        }

        $this->em->persist($task);
        $this->em->flush();

        return $task;
    }

    private function createRelativePitchSound(TaskDto $dto): RelativePitchSound
    {
        $task = new RelativePitchSound();
        $task
            ->setFirstNote($dto->getFirstNote())
            ->setSecondNote($dto->getSecondNote())
        ;

        return $task;
    }

    private function createInterval(TaskDto $dto): Interval
    {
        $task = new Interval();
        $task
            ->setFirstNote($dto->getFirstNote())
            ->setSecondNote($dto->getSecondNote())
            ->setIsHarmonic($dto->isHarmonic())
        ;

        return $task;
    }

    public function update(AbstractTask $task, TaskDto $dto): AbstractTask
    {
        $previousTask = $dto->getPreviousTask();
        $originalPreviousTask = $task->getPreviousTask();

        $task
            ->setName($dto->getName())
            ->setDescription($dto->getDescription())
            ->setPoints($dto->getPoints());

        switch ($task->getType()) {
            case TaskTypeEnum::RelativePitchSound:
                $task
                    ->setFirstNote($dto->getFirstNote())
                    ->setSecondNote($dto->getSecondNote());
                break;
            case TaskTypeEnum::Interval:
                $task
                    ->setFirstNote($dto->getFirstNote())
                    ->setSecondNote($dto->getSecondNote())
                    ->setIsHarmonic($dto->isHarmonic());
                break;
        }

        if ($originalPreviousTask === $previousTask) {
            $this->em->flush();

            return $task;
        }

        $tasks = $this->getTasksForNode($task->getNode());

        $originalTasksOrder = array_map(fn(AbstractTask $item) => $item->getId(), $tasks);
        $newTasksOrder = [];
        if (!$previousTask) {
            $newTasksOrder[] = $task->getId();
        }
        foreach ($originalTasksOrder as $key => $value) {
            if ($value === $previousTask?->getId()) {
                $newTasksOrder[] = $value;
                $newTasksOrder[] = $task->getId();
                continue;
            }

            if ($value === $task->getId()) {
                continue;
            }

            $newTasksOrder[] = $value;
        }

        /** @var AbstractTask $item */
        foreach ($tasks as $item) {
            $item->setPreviousTask(null);
            $item->setNextTask(null);
        }

        $this->em->flush();

        foreach ($newTasksOrder as $key => $item) {
            if ($key === 0) {
                continue;
            }
            $prev = $this->abstractTaskRepository->findOneBy(['id' => $newTasksOrder[$key - 1]]);
            $current = $this->abstractTaskRepository->findOneBy(['id' => $item]);

            $current->setPreviousTask($prev);
            $prev->setNextTask($current);
        }

        $this->em->flush();

        return $task;
    }

    public function delete(AbstractTask $task): void
    {
        $previousTaskId = $task->getPreviousTask()?->getId();
        $nextTaskId = $task->getNextTask()?->getId();

        $task->setPreviousTask(null);
        $task->getPreviousTask()?->setNextTask(null);
        $task->setNextTask(null);
        $task->getNextTask()?->setPreviousTask(null);

        $this->em->flush();

        $previousTask = $this->abstractTaskRepository->findOneBy(['id' => $previousTaskId]);
        $nextTask =  $this->abstractTaskRepository->findOneBy(['id' => $nextTaskId]);

        $previousTask?->setNextTask($nextTask);
        $nextTask?->setPreviousTask($previousTask);

        $this->em->remove($task);
        $this->em->flush();
    }
}
