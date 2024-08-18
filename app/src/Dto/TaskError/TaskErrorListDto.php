<?php

namespace App\Dto\TaskError;

use App\Entity\Enum\TaskTypeEnum;

class TaskErrorListDto
{
    public function __construct(
        private readonly int $id,
        private readonly string $taskSlug,
        private readonly string $name,
        private readonly string $nodeSlug,
        private readonly string $courseSlug,
        private readonly TaskTypeEnum $type,
        private readonly ?string $description = null
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getTaskSlug(): string
    {
        return $this->taskSlug;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNodeSlug(): string
    {
        return $this->nodeSlug;
    }

    public function getCourseSlug(): string
    {
        return $this->courseSlug;
    }

    public function getType(): TaskTypeEnum
    {
        return $this->type;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}