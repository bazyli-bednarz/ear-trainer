<?php

namespace App\Dto\Course;

use App\Entity\Course;

class CourseMenuDto
{
    public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly string $slug,
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    static function fromEntity(Course $course): self
    {
        return new self(
            $course->getId(),
            $course->getName(),
            $course->getSlug(),
        );
    }
}