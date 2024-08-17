<?php

namespace App\Service\Node;

use App\Dto\Node\CreateNodeDto;
use App\Dto\Node\EditNodeDto;
use App\Entity\Course;
use App\Entity\Node;
use App\Entity\User;

interface NodeServiceInterface
{

    public function getFirstNodeForCourse(Course $course): ?Node;
    public function getLastNodeForCourse(Course $course): ?Node;
    public function getNodesForCourse(Course $course): array;
    public function getNodesForCourseWithUserInfo(Course $course, User $user): array;
    public function isNodeCompleted(Node $node, User $user): bool;


    public function getNodesForCourseExceptGiven(Course $course, Node $node): array;

    public function getById(int $id): ?Node;

    public function create(CreateNodeDto $dto, Course $course): Node;

    public function update(Node $node, EditNodeDto $dto): Node;

    public function delete(Node $node): void;
}