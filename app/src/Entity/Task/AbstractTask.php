<?php

namespace App\Entity\Task;

use App\Entity\Enum\TaskTypeEnum;
use App\Entity\Node;
use App\Entity\Trait\IdTrait;
use App\Entity\Trait\SluggableTrait;
use App\Entity\Trait\TimestampableTrait;
use App\Repository\AbstractTaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AbstractTaskRepository::class)]
#[ORM\Table(name: 'tasks')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'dtype', type: 'string')]
#[ORM\DiscriminatorMap([
    'RelativePitchSound' => RelativePitchSound::class,
    'Interval' => Interval::class,
    'TwoIntervals' => TwoIntervals::class,
    'IntervalChain' => IntervalChain::class,
    'ThreeNoteChord' => ThreeNoteChord::class,
])]
abstract class AbstractTask
{
    use IdTrait;
    use TimestampableTrait;
    use SluggableTrait;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private string $name;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    public TaskTypeEnum $type;

    #[ORM\Column(type: 'integer')]
    private int $points;

    #[ORM\OneToOne(targetEntity: self::class, inversedBy: 'nextTask', cascade: ['persist', 'remove'])]
    private ?self $previousTask = null;

    #[ORM\OneToOne(targetEntity: self::class, mappedBy: 'previousTask', cascade: ['persist', 'remove'])]
    private ?self $nextTask = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Node $node = null;

    abstract public function getType(): TaskTypeEnum;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): static
    {
        $this->points = $points;

        return $this;
    }

    public function getPreviousTask(): ?self
    {
        return $this->previousTask;
    }

    public function setPreviousTask(?self $previousTask): static
    {
        $this->previousTask = $previousTask;

        return $this;
    }

    public function getNextTask(): ?self
    {
        return $this->nextTask;
    }

    public function setNextTask(?self $nextTask): static
    {
        // unset the owning side of the relation if necessary
        if ($nextTask === null && $this->nextTask !== null) {
            $this->nextTask->setPreviousTask(null);
        }

        // set the owning side of the relation if necessary
        if ($nextTask !== null && $nextTask->getPreviousTask() !== $this) {
            $nextTask->setPreviousTask($this);
        }

        $this->nextTask = $nextTask;

        return $this;
    }

    public function getNode(): ?Node
    {
        return $this->node;
    }

    public function setNode(?Node $node): static
    {
        $this->node = $node;

        return $this;
    }
}
