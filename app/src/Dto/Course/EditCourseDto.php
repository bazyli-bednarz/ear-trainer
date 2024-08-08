<?php

namespace App\Dto\Course;

use App\Entity\Course;

class EditCourseDto
{
    private string $name;
    private ?string $description;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public static function fromEntity(Course $course): self
    {
        $dto = new self();
        $dto->setName($course->getName());
        $dto->setDescription($course->getDescription());

        return $dto;
    }
}