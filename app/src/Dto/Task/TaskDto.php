<?php

namespace App\Dto\Task;

use App\Entity\Course;
use App\Entity\Enum\NoteEnum;
use App\Entity\Enum\TaskTypeEnum;
use App\Entity\Node;
use App\Entity\Task\AbstractTask;

class TaskDto
{
    public function __construct(
        TaskTypeEnum $type,
    )
    {
        $this->type = $type;
    }

    private string $name;
    private ?string $description = null;
    private Node $node;
    private Course $course;
    private int $points;
    private ?AbstractTask $previousTask = null;

    private TaskTypeEnum $type;

    // Variable fields
    private ?NoteEnum $firstNote = null;
    private ?NoteEnum $secondNote = null;
    private ?bool $isHarmonic = null;

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

    public function getNode(): Node
    {
        return $this->node;
    }

    public function setNode(Node $node): void
    {
        $this->node = $node;
    }

    public function getCourse(): Course
    {
        return $this->course;
    }

    public function setCourse(Course $course): void
    {
        $this->course = $course;
    }

    public function getIsHarmonic(): ?bool
    {
        return $this->isHarmonic;
    }

    public function setIsHarmonic(?bool $isHarmonic): void
    {
        $this->isHarmonic = $isHarmonic;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function setPoints(int $points): void
    {
        $this->points = $points;
    }

    public function getPreviousTask(): ?AbstractTask
    {
        return $this->previousTask;
    }

    public function setPreviousTask(?AbstractTask $previousTask): void
    {
        $this->previousTask = $previousTask;
    }

    public function getType(): TaskTypeEnum
    {
        return $this->type;
    }

    public function getFirstNote(): ?NoteEnum
    {
        return $this->firstNote;
    }

    public function setFirstNote(?NoteEnum $firstNote): void
    {
        $this->firstNote = $firstNote;
    }

    public function getSecondNote(): ?NoteEnum
    {
        return $this->secondNote;
    }

    public function setSecondNote(?NoteEnum $secondNote): void
    {
        $this->secondNote = $secondNote;
    }

    public function isHarmonic(): ?bool
    {
        return $this->isHarmonic;
    }

    public function setHarmonic(?bool $isHarmonic): void
    {
        $this->isHarmonic = $isHarmonic;
    }

    public function setType(TaskTypeEnum $type): void
    {
        $this->type = $type;
    }

    public static function fromEntity(AbstractTask $task): self
    {
        $dto = new self($task->getType());
        $dto->setName($task->getName());
        $dto->setDescription($task->getDescription());
        $dto->setPoints($task->getPoints());
        $dto->setPreviousTask($task->getPreviousTask());

        switch ($task->getType()) {
            case TaskTypeEnum::RelativePitchSound:
                $dto->setFirstNote($task->getFirstNote());
                $dto->setSecondNote($task->getSecondNote());
                break;
            case TaskTypeEnum::Interval:
                $dto->setFirstNote($task->getFirstNote());
                $dto->setSecondNote($task->getSecondNote());
                $dto->setIsHarmonic($task->isHarmonic());
                break;
            default:
                throw new \InvalidArgumentException('Invalid task type');
        }

        return $dto;
    }
}