<?php

namespace App\Service\Award;

use App\Dto\Course\CreateCourseDto;
use App\Dto\Course\EditCourseDto;
use App\Entity\Award;
use App\Entity\Course;
use App\Entity\Enum\AwardEnum;
use App\Entity\User;

interface AwardServiceInterface
{
    public function getAwardsForUser(User $user): array;
    public function getLastAwardsForUser(User $user, int $limit = 3): array;

    public function addAward(User $user, AwardEnum $type): ?Award;
}
