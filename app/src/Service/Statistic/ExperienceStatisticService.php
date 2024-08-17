<?php

namespace App\Service\Statistic;

use App\Dto\Task\TaskDto;
use App\Dto\TaskAnswer\AnswerFeedbackDto;
use App\Dto\TaskAnswer\TaskAnswerDto;
use App\Entity\Enum\ThreeNoteChordTypeEnum;
use App\Entity\Enum\TwoIntervalsTypeEnum;
use App\Entity\Statistic\ExperienceStatistic;
use App\Entity\Statistic\TaskStatistic;
use App\Entity\User;
use App\Repository\Statistic\ExperienceStatisticRepository;
use App\Repository\Statistic\TaskStatisticRepository;
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

class ExperienceStatisticService implements ExperienceStatisticServiceInterface
{
    public function __construct(
        private readonly ExperienceStatisticRepository $experienceStatisticRepository,
        private readonly EntityManagerInterface        $em,
        private readonly TranslatorInterface           $translator,
    )
    {
    }


    public function getExperienceByUser(User $user): int
    {
        try {
            return $this->experienceStatisticRepository->getExperienceByUser($user);
        } catch (NoResultException | NonUniqueResultException $e) {
            return 0;
        }
    }

    public function getExperienceInRange(User $user, DateTimeImmutable $start, DateTimeImmutable $end): int
    {
        try {
            return $this->experienceStatisticRepository->getExperienceInRange($user, $start, $end);
        } catch (NoResultException | NonUniqueResultException $e) {
            return 0;
        }
    }

    public function addExperience(User $user, int $points): void
    {
        $experience = new ExperienceStatistic();
        $experience->setUser($user);
        $experience->setPoints($points);
        $this->em->persist($experience);
        $this->em->flush();
    }

    public function getLevelByExperience(int $experience): int
    {
        $level = 1;
        $experienceForLevel = 100;
        while ($experience >= $experienceForLevel) {
            $level++;
            $experienceForLevel += $level * 100;
        }
        return $level;
    }

    public function getExperienceToLevelUp(int $level): int
    {
        $experience = 100;
        for ($i = 1; $i < $level; $i++) {
            $experience += $i * 100;
        }
        return $experience;
    }

    public function getExperienceOnCurrentLevel(int $experience): int
    {
        $level = 1;
        $experienceToLevelUp = $this->getExperienceToLevelUp($level);
        while ($experience > $experienceToLevelUp) {
            if ($experience - $this->getExperienceToLevelUp($level) < 0) {
                return $experience;
            }
            $experience -= $this->getExperienceToLevelUp($level);
            $level++;
        }

        return $experience;
    }
}
