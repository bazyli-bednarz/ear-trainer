<?php

namespace App\Service\Award;

use App\Dto\Course\CourseMenuDto;
use App\Dto\Course\CreateCourseDto;
use App\Dto\Course\EditCourseDto;
use App\Entity\Award;
use App\Entity\Course;
use App\Entity\Enum\AwardEnum;
use App\Entity\Node;
use App\Entity\User;
use App\Repository\AwardRepository;
use App\Repository\CourseRepository;
use App\Service\Course\CourseServiceInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

class AwardService implements AwardServiceInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly AwardRepository $awardRepository,
    )
    {
    }

    public function getAwardsForUser(User $user): array
    {
        return $this->awardRepository->findBy(['user' => $user]);
    }

    public function addAward(User $user, AwardEnum $type): ?Award
    {
        if ($this->awardRepository->findOneBy(['user' => $user, 'type' => $type]) !== null) {
            return null;
        }

        $award = new Award();
        $award->setType($type);
        $award->setUser($user);
        $this->em->persist($award);
        $this->em->flush();

        return $award;
    }
}
