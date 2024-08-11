<?php

namespace App\Dto\Node;

use App\Entity\Course;
use App\Entity\Node;

class EditNodeDto
{
    private string $name;
    private ?string $description;
    private string $icon;
    private ?Course $course = null;
    private ?Node $previousNode = null;

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

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): void
    {
        $this->course = $course;
    }

    public function getPreviousNode(): ?Node
    {
        return $this->previousNode;
    }

    public function setPreviousNode(?Node $previousNode): void
    {
        $this->previousNode = $previousNode;
    }

    public static function fromEntity(Node $node): self
    {
        $self = new self();
        $self->setName($node->getName());
        $self->setDescription($node->getDescription());
        $self->setIcon($node->getIcon());
        $self->setCourse($node->getCourse());
        $self->setPreviousNode($node->getPreviousNode());

        return $self;
    }
}