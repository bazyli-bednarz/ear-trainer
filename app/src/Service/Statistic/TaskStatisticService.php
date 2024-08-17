<?php

namespace App\Service\Statistic;

use App\Dto\Task\TaskDto;
use App\Dto\TaskAnswer\AnswerFeedbackDto;
use App\Dto\TaskAnswer\TaskAnswerDto;
use App\Entity\Enum\ThreeNoteChordTypeEnum;
use App\Entity\Enum\TwoIntervalsTypeEnum;
use App\Entity\Statistic\TaskStatistic;
use App\Entity\User;
use App\Repository\Statistic\TaskStatisticRepository;
use App\Service\TaskAnswer\TaskAnswerServiceInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
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
use App\Service\Task\TaskServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use function Symfony\Component\Translation\t;

class TaskStatisticService implements TaskStatisticServiceInterface
{
    public function __construct(
        private readonly TaskStatisticRepository $taskStatisticRepository,
        private readonly EntityManagerInterface $em,
        private readonly TranslatorInterface    $translator,
    )
    {
    }


    public function getTaskStatisticsByUser(User $user, int $taskId): array
    {
        return $this->taskStatisticRepository->getTaskStatisticsByUser($user, $taskId);
    }

    public function countTaskStatisticsByUser(User $user): int
    {
        return count($this->taskStatisticRepository->findBy(['user' => $user]));
    }

    public function addStatistic(User $user, AbstractTask $task): TaskStatistic
    {
        $taskStatistic = new TaskStatistic();
        $taskStatistic->setUser($user);
        $taskStatistic->setTaskId($task->getId());
        $this->em->persist($taskStatistic);
        $this->em->flush();

        return $taskStatistic;
    }

    public function determinePoints(User $user, AbstractTask $task): int
    {
        $numberOfAttempts = count($this->getTaskStatisticsByUser($user, $task->getId()));

        $points = $task->getPoints() / (1 + $numberOfAttempts);

        return (int) floor ($points);
    }

    public function isTaskCompletedByUser(User $user, AbstractTask $task): bool
    {
        $taskStatistics = $this->getTaskStatisticsByUser($user, $task->getId());
        return count($taskStatistics) > 0;
    }

    public function getCompletedTasksCountForNode(Node $node, User $user): int
    {
        $tasks = $node->getTasks();
        $completedTasksCount = 0;
        foreach ($tasks as $task) {
            if ($this->isTaskCompletedByUser($user, $task)) {
                $completedTasksCount++;
            }
        }

        return min($completedTasksCount, count($node->getTasks()));
    }
}
