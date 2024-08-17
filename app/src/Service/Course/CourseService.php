<?php

namespace App\Service\Course;

use App\Dto\Course\CourseMenuDto;
use App\Dto\Course\CreateCourseDto;
use App\Dto\Course\EditCourseDto;
use App\Entity\Course;
use App\Entity\Node;
use App\Entity\User;
use App\Repository\CourseRepository;
use App\Service\Node\NodeServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class CourseService implements CourseServiceInterface
{
    public function __construct(
        private readonly CourseRepository       $courseRepository,
        private readonly EntityManagerInterface $em,
        private readonly NodeServiceInterface   $nodeService,
    )
    {
    }

    public function getMenuList(): array
    {
        $courses = $this->courseRepository->queryAll()->getQuery()->getResult();
        $data = [];
        foreach ($courses as $course) {
            $data[] = CourseMenuDto::fromEntity($course);
        }

        return $data;
    }

    public function getById(int $id): ?Course
    {
        return $this->courseRepository->findOneBy(['id' => $id]);
    }

    public function create(CreateCourseDto $dto): Course
    {
        $course = new Course();
        $course->setName($dto->getName());
        $course->setDescription($dto->getDescription());

        $this->em->persist($course);
        $this->em->flush();

        return $course;
    }

    public function update(Course $course, EditCourseDto $dto): Course
    {
        $course->setName($dto->getName());
        $course->setDescription($dto->getDescription());

        $this->em->flush();

        return $course;
    }

    public function delete(Course $course): void
    {
        $this->em->remove($course);
        $this->em->flush();
    }

    public function hasUserCompletedAllNodes(User $user, Course $course): bool
    {
        $nodes = $course->getNodes();

        if (empty($nodes)) {
            return false;
        }

        /** @var Node $node */
        foreach ($nodes as $node) {
            if (!$this->nodeService->isNodeCompleted($node, $user)) {
                return false;
            }
        }

        return true;
    }
}
