<?php

namespace App\Service\Statistic;

use App\Dto\Task\TaskDto;
use App\Dto\TaskAnswer\AnswerFeedbackDto;
use App\Dto\TaskAnswer\TaskAnswerDto;
use App\Dto\User\UserExperienceDto;
use App\Entity\Enum\ThreeNoteChordTypeEnum;
use App\Entity\Enum\TwoIntervalsTypeEnum;
use App\Entity\Statistic\ExperienceStatistic;
use App\Entity\Statistic\TaskError;
use App\Entity\Statistic\TaskStatistic;
use App\Entity\User;
use App\Repository\Statistic\ExperienceStatisticRepository;
use App\Repository\Statistic\TaskErrorRepository;
use App\Repository\Statistic\TaskStatisticRepository;
use App\Service\Award\AwardServiceInterface;
use App\Service\TaskAnswer\TaskAnswerServiceInterface;
use DateTimeImmutable;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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

class TaskErrorService implements TaskErrorServiceInterface
{
    public function __construct(
        private readonly TaskErrorRepository $taskErrorRepository,
        private readonly EntityManagerInterface $em,
    )
    {
    }

    public function getTaskErrorsByUser(User $user): array
    {
        return $this->taskErrorRepository->findBy(['user' => $user]);
    }

    public function addTaskError(User $user, int $taskId): ?TaskError
    {
        if ($this->taskErrorRepository->findOneBy(['user' => $user, 'taskId' => $taskId])) {
            return null;
        }

        $taskError = new TaskError();
        $taskError->setUser($user);
        $taskError->setTaskId($taskId);
        $this->em->persist($taskError);
        $this->em->flush();

        return $taskError;
    }

    public function getTaskError(AbstractTask $task, User $user): ?TaskError
    {
        return $this->taskErrorRepository->findOneBy(['user' => $user, 'taskId' => $task->getId()]);
    }

    public function delete(TaskError $taskError): void
    {
        $this->em->remove($taskError);
        $this->em->flush();
    }
}
