<?php

namespace App\Service\Course;

use App\Dto\Course\CourseMenuDto;
use App\Repository\CourseRepository;
use Knp\Component\Pager\PaginatorInterface;

class CourseService implements CourseServiceInterface
{
    public function __construct(
        private readonly CourseRepository $courseRepository,
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
}
