<?php

namespace App\Dto\Task;

use App\Entity\Enum\TaskTypeEnum;

class TaskWithUserInfoDto
{
    public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly string $slug,
        private readonly TaskTypeEnum $type,
        private readonly ?string $description,
        private readonly int $points,
        private readonly int $originalPoints,
        private readonly bool $isCompleted,
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

    public function getType(): TaskTypeEnum
    {
        return $this->type;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function getOriginalPoints(): int
    {
        return $this->originalPoints;
    }

    public function isCompleted(): bool
    {
        return $this->isCompleted;
    }
}