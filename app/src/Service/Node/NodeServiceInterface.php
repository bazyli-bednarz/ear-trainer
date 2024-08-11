<?php

namespace App\Service\Node;

use App\Dto\Node\CreateNodeDto;
use App\Dto\Node\EditNodeDto;
use App\Entity\Course;
use App\Entity\Node;

interface NodeServiceInterface
{
    public function getNodesForCourse(Course $course): array;

    public function getNodesForCourseExceptGiven(Course $course, Node $node): array;

    public function getById(int $id): ?Node;

    public function create(CreateNodeDto $dto, Course $course): Node;

    public function update(Node $node, EditNodeDto $dto): Node;

    public function delete(Node $node): void;
}