<?php

namespace App\Service\Statistic;

use App\Entity\Node;
use App\Entity\Statistic\TaskStatistic;
use App\Entity\Task\AbstractTask;
use App\Entity\User;
use DateTimeImmutable;

interface ExperienceStatisticServiceInterface
{

    public function getExperienceByUser(User $user): int;
    public function getExperienceInRange(User $user, DateTimeImmutable $start, DateTimeImmutable $end): int;
    public function addExperience(User $user, int $points): void;
    public function getLevelByExperience(int $experience): int;
    public function getExperienceOnCurrentLevel(int $experience): int;
    public function getExperienceToLevelUp(int $level): int;
    public function getTopExperienceUsers(int $limit): array;

}