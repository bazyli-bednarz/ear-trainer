<?php

namespace App\Dto\Node;

use App\Entity\Enum\TaskTypeEnum;

class NodeWithUserInfoDto
{
    public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly string $slug,
        private readonly ?string $description,
        private readonly bool $isCompleted,
        private readonly string $icon,
        private readonly int $completedNodes,
        private readonly int $totalNodes,
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


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function isCompleted(): bool
    {
        return $this->isCompleted;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getCompletedNodes(): int
    {
        return $this->completedNodes;
    }

    public function getTotalNodes(): int
    {
        return $this->totalNodes;
    }
}