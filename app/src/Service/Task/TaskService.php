<?php

namespace App\Service\Task;

use App\Dto\Task\TaskDto;
use App\Entity\Enum\TaskTypeEnum;
use App\Entity\Node;
use App\Entity\Task\AbstractTask;
use App\Entity\Task\FourNoteChord;
use App\Entity\Task\Interval;
use App\Entity\Task\IntervalChain;
use App\Entity\Task\RelativePitchSound;
use App\Entity\Task\Scale;
use App\Entity\Task\ThreeNoteChord;
use App\Entity\Task\TwoIntervals;
use App\Repository\AbstractTaskRepository;
use Doctrine\ORM\EntityManagerInterface;

class TaskService implements TaskServiceInterface
{
    public function __construct(
        private readonly AbstractTaskRepository       $abstractTaskRepository,
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
            TaskTypeEnum::TwoIntervals => $this->createTwoIntervals($dto),
            TaskTypeEnum::IntervalChain => $this->createIntervalChain($dto),
            TaskTypeEnum::ThreeNoteChord => $this->createThreeNoteChord($dto),
            TaskTypeEnum::FourNoteChord => $this->createFourNoteChord($dto),
            TaskTypeEnum::Scale => $this->createScale($dto),
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
            ->setIntervalType($dto->getIntervalType())
            ->setIsHarmonic($dto->isHarmonic())
        ;

        return $task;
    }

    private function createTwoIntervals(TaskDto $dto): TwoIntervals
    {
        $task = new TwoIntervals();
        $task
            ->setFirstNote($dto->getFirstNote())
            ->setSecondNote($dto->getSecondNote())
            ->setFirstIntervalType($dto->getFirstIntervalType())
            ->setSecondIntervalType($dto->getSecondIntervalType())
            ->setIsFirstHarmonic($dto->isFirstHarmonic())
            ->setIsSecondHarmonic($dto->isSecondHarmonic())
        ;

        return $task;
    }

    private function createIntervalChain(TaskDto $dto): IntervalChain
    {
        $task = new IntervalChain();
        $task
            ->setFirstNote($dto->getFirstNote())
            ->setIsHarmonic($dto->isHarmonic())
            ->setIntervalType($dto->getIntervalType())
        ;

        return $task;
    }

    private function createThreeNoteChord(TaskDto $dto): ThreeNoteChord
    {
        $task = new ThreeNoteChord();
        $task
            ->setFirstNote($dto->getFirstNote())
            ->setChord($dto->getChord())
            ->setInversion($dto->getInversion())
            ->setIsHarmonic($dto->isHarmonic())
            ->setShouldStudentRecogniseInversion($dto->getShouldStudentRecogniseInversion())
        ;

        return $task;
    }

    public function createFourNoteChord(TaskDto $dto): FourNoteChord
    {
        $task = new FourNoteChord();
        $task
            ->setFirstNote($dto->getFirstNote())
            ->setIsHarmonic($dto->isHarmonic())
            ->setFourNoteChord($dto->getFourNoteChord())
        ;

        return $task;
    }

    public function createScale(TaskDto $dto): Scale
    {
        $task = new Scale();
        $task
            ->setFirstNote($dto->getFirstNote())
            ->setScaleType($dto->getScaleType())
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
                /** @var RelativePitchSound $task */
                $task
                    ->setFirstNote($dto->getFirstNote())
                    ->setSecondNote($dto->getSecondNote());
                break;
            case TaskTypeEnum::Interval:
                /** @var Interval $task */
                $task
                    ->setFirstNote($dto->getFirstNote())
                    ->setIntervalType($dto->getIntervalType())
                    ->setIsHarmonic($dto->isHarmonic());
                break;
            case TaskTypeEnum::TwoIntervals:
                /** @var TwoIntervals $task */
                $task
                    ->setFirstNote($dto->getFirstNote())
                    ->setSecondNote($dto->getSecondNote())
                    ->setFirstIntervalType($dto->getFirstIntervalType())
                    ->setSecondIntervalType($dto->getSecondIntervalType())
                    ->setIsFirstHarmonic($dto->isFirstHarmonic())
                    ->setIsSecondHarmonic($dto->isSecondHarmonic());
                break;
            case TaskTypeEnum::IntervalChain:
                /** @var IntervalChain $task */
            $task
                    ->setFirstNote($dto->getFirstNote())
                    ->setIsHarmonic($dto->isHarmonic())
                    ->setIntervalType($dto->getIntervalType());
                break;
            case TaskTypeEnum::ThreeNoteChord:
                /** @var ThreeNoteChord $task */
                $task
                    ->setFirstNote($dto->getFirstNote())
                    ->setChord($dto->getChord())
                    ->setInversion($dto->getInversion())
                    ->setIsHarmonic($dto->isHarmonic())
                    ->setShouldStudentRecogniseInversion($dto->getShouldStudentRecogniseInversion());
                break;
            case TaskTypeEnum::FourNoteChord:
                /** @var FourNoteChord $task */
                $task
                    ->setFirstNote($dto->getFirstNote())
                    ->setIsHarmonic($dto->isHarmonic())
                    ->setFourNoteChord($dto->getFourNoteChord());
                break;
            case TaskTypeEnum::Scale:
                /** @var Scale $task */
                $task
                    ->setFirstNote($dto->getFirstNote())
                    ->setScaleType($dto->getScaleType());
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
