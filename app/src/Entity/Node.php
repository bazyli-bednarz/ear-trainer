<?php

namespace App\Entity;

use App\Entity\Trait\IdTrait;
use App\Entity\Trait\SluggableTrait;
use App\Entity\Trait\TimestampableTrait;
use App\Repository\NodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NodeRepository::class)]
class Node
{
    use IdTrait;
    use TimestampableTrait;
    use SluggableTrait;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $icon = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'nodes')]
    private ?Course $course = null;

    #[ORM\OneToOne(targetEntity: self::class, inversedBy: 'nextNode', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private ?self $previousNode = null;

    #[ORM\OneToOne(targetEntity: self::class, mappedBy: 'previousNode', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private ?self $nextNode = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): static
    {
        $this->course = $course;

        return $this;
    }

    public function getPreviousNode(): ?self
    {
        return $this->previousNode;
    }

    public function setPreviousNode(?self $previousNode): static
    {
        $this->previousNode = $previousNode;

        return $this;
    }

    public function getNextNode(): ?self
    {
        return $this->nextNode;
    }

    public function setNextNode(?self $nextNode): static
    {
        // unset the owning side of the relation if necessary
        if ($nextNode === null && $this->nextNode !== null) {
            $this->nextNode->setPreviousNode(null);
        }

        // set the owning side of the relation if necessary
        if ($nextNode !== null && $nextNode->getPreviousNode() !== $this) {
            $nextNode->setPreviousNode($this);
        }

        $this->nextNode = $nextNode;

        return $this;
    }
}
