<?php

namespace App\Dto\Task;

use App\Entity\Course;
use App\Entity\Enum\FourNoteChordTypeEnum;
use App\Entity\Enum\IntervalEnum;
use App\Entity\Enum\InversionTypeEnum;
use App\Entity\Enum\NoteEnum;
use App\Entity\Enum\ScaleTypeEnum;
use App\Entity\Enum\TaskTypeEnum;
use App\Entity\Enum\ThreeNoteChordTypeEnum;
use App\Entity\Enum\TwoIntervalsTypeEnum;
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
    private ?bool $isFirstHarmonic = null;
    private ?bool $isSecondHarmonic = null;
    private ?IntervalEnum $intervalType = null;
    private ?IntervalEnum $firstIntervalType = null;
    private ?IntervalEnum $secondIntervalType = null;
    private ?TwoIntervalsTypeEnum $twoIntervalsType = null;
    private ?ThreeNoteChordTypeEnum $chord = null;
    private ?InversionTypeEnum $inversion = null;
    private ?bool $shouldStudentRecogniseInversion = null;
    private ?FourNoteChordTypeEnum $fourNoteChord = null;
    private ?ScaleTypeEnum $scaleType = null;

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

    public function isHarmonic(): ?bool
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

    public function setHarmonic(?bool $isHarmonic): void
    {
        $this->isHarmonic = $isHarmonic;
    }
    public function isFirstHarmonic(): ?bool
    {
        return $this->isFirstHarmonic;
    }

    public function setIsFirstHarmonic(?bool $isFirstHarmonic): void
    {
        $this->isFirstHarmonic = $isFirstHarmonic;
    }

    public function isSecondHarmonic(): ?bool
    {
        return $this->isSecondHarmonic;
    }

    public function setIsSecondHarmonic(?bool $isSecondHarmonic): void
    {
        $this->isSecondHarmonic = $isSecondHarmonic;
    }

    public function getTwoIntervalsType(): ?TwoIntervalsTypeEnum
    {
        return $this->twoIntervalsType;
    }

    public function setTwoIntervalsType(?TwoIntervalsTypeEnum $twoIntervalsType): void
    {
        $this->twoIntervalsType = $twoIntervalsType;
    }

    public function getIntervalType(): ?IntervalEnum
    {
        return $this->intervalType;
    }

    public function setIntervalType(?IntervalEnum $intervalType): void
    {
        $this->intervalType = $intervalType;
    }

    public function getFirstIntervalType(): ?IntervalEnum
    {
        return $this->firstIntervalType;
    }

    public function setFirstIntervalType(?IntervalEnum $firstIntervalType): void
    {
        $this->firstIntervalType = $firstIntervalType;
    }

    public function getSecondIntervalType(): ?IntervalEnum
    {
        return $this->secondIntervalType;
    }

    public function setSecondIntervalType(?IntervalEnum $secondIntervalType): void
    {
        $this->secondIntervalType = $secondIntervalType;
    }

    public function setType(TaskTypeEnum $type): void
    {
        $this->type = $type;
    }

    public function getChord(): ?ThreeNoteChordTypeEnum
    {
        return $this->chord;
    }

    public function setChord(?ThreeNoteChordTypeEnum $chord): void
    {
        $this->chord = $chord;
    }

    public function getInversion(): ?InversionTypeEnum
    {
        return $this->inversion;
    }

    public function setInversion(?InversionTypeEnum $inversion): void
    {
        $this->inversion = $inversion;
    }

    public function getShouldStudentRecogniseInversion(): ?bool
    {
        return $this->shouldStudentRecogniseInversion;
    }

    public function setShouldStudentRecogniseInversion(?bool $shouldStudentRecogniseInversion): void
    {
        $this->shouldStudentRecogniseInversion = $shouldStudentRecogniseInversion;
    }

    public function getFourNoteChord(): ?FourNoteChordTypeEnum
    {
        return $this->fourNoteChord;
    }

    public function setFourNoteChord(?FourNoteChordTypeEnum $fourNoteChord): void
    {
        $this->fourNoteChord = $fourNoteChord;
    }

    public function getScaleType(): ?ScaleTypeEnum
    {
        return $this->scaleType;
    }

    public function setScaleType(?ScaleTypeEnum $scaleType): void
    {
        $this->scaleType = $scaleType;
    }

    public function getUpperEdgeIntervalType(): IntervalEnum
    {
        return IntervalEnum::fromInt(abs($this->getThirdNoteIndex() - $this->getFourthNoteIndex()));
    }

    public function getLowerEdgeIntervalType(): IntervalEnum
    {
        return IntervalEnum::fromInt(abs($this->getFirstNoteIndex() - $this->getSecondNoteIndex()));
    }

    public function getFirstNoteIndex(): int
    {
        return NoteEnum::getIndex($this->getFirstNote());
    }

    public function getSecondNoteIndex(): int
    {
        return NoteEnum::getIndex($this->getSecondNote());
    }


    /**
     * Second note for first interval
     */
    public function getThirdNote(): NoteEnum
    {
        return NoteEnum::fromInt(NoteEnum::getIndex($this->firstNote) + IntervalEnum::getHalfSteps($this->firstIntervalType));
    }

    public function getThirdNoteIndex(): int
    {
        return NoteEnum::getIndex($this->getThirdNote());
    }

    /**
     * Second note for second interval
     */
    public function getFourthNote(): NoteEnum
    {
        return NoteEnum::fromInt(NoteEnum::getIndex($this->secondNote) + IntervalEnum::getHalfSteps($this->secondIntervalType));
    }

    public function getFourthNoteIndex(): int
    {
        return NoteEnum::getIndex($this->getFourthNote());
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
                $dto->setIntervalType($task->getIntervalType());
                $dto->setIsHarmonic($task->isHarmonic());
                break;
            case TaskTypeEnum::TwoIntervals:
                $dto->setFirstNote($task->getFirstNote());
                $dto->setSecondNote($task->getSecondNote());
                $dto->setFirstIntervalType($task->getFirstIntervalType());
                $dto->setSecondIntervalType($task->getSecondIntervalType());
                $dto->setIsFirstHarmonic($task->isFirstHarmonic());
                $dto->setIsSecondHarmonic($task->isSecondHarmonic());
                $dto->setTwoIntervalsType($task->getTwoIntervalsTypeEnum());
                break;
            case TaskTypeEnum::IntervalChain:
                $dto->setFirstNote($task->getFirstNote());
                $dto->setIsHarmonic($task->isHarmonic());
                $dto->setIntervalType($task->getIntervalType());
                break;
            case TaskTypeEnum::ThreeNoteChord:
                $dto->setFirstNote($task->getFirstNote());
                $dto->setChord($task->getChord());
                $dto->setInversion($task->getInversion());
                $dto->setIsHarmonic($task->isHarmonic());
                $dto->setShouldStudentRecogniseInversion($task->getShouldStudentRecogniseInversion());
                break;
            case TaskTypeEnum::FourNoteChord:
                $dto->setFirstNote($task->getFirstNote());
                $dto->setIsHarmonic($task->isHarmonic());
                $dto->setFourNoteChord($task->getFourNoteChord());
                break;
            case TaskTypeEnum::Scale:
                $dto->setFirstNote($task->getFirstNote());
                $dto->setScaleType($task->getScaleType());
                break;
            default:
                throw new \InvalidArgumentException('Invalid task type');
        }

        return $dto;
    }
}