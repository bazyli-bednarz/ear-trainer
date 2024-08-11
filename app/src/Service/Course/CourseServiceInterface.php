<?php

namespace App\Service\Course;

use App\Dto\Course\CreateCourseDto;
use App\Dto\Course\EditCourseDto;
use App\Entity\Course;

interface CourseServiceInterface
{
    public function getMenuList(): array;
    public function getById(int $id): ?Course;
    public function create(CreateCourseDto $dto): Course;
    public function update(Course $course, EditCourseDto $dto): Course;
    public function delete(Course $course): void;
}
