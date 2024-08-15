<?php

namespace App\Entity\Task;

use App\Entity\Enum\IntervalEnum;
use App\Entity\Enum\NoteEnum;
use App\Entity\Enum\TaskTypeEnum;
use App\Repository\IntervalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IntervalRepository::class)]
class Interval extends AbstractTask
{
    public function __construct()
    {
        $this->type = TaskTypeEnum::Interval;
    }

    #[ORM\Column(type: 'string', length: 3, enumType: NoteEnum::class)]
    private ?NoteEnum $firstNote = null;
    #[ORM\Column(type: 'string', length: 30, enumType: IntervalEnum::class)]
    private ?IntervalEnum $intervalType = null;
    #[ORM\Column(type: 'boolean')]
    private ?bool $isHarmonic = null;

    public function getType(): TaskTypeEnum
    {
        $this->type = TaskTypeEnum::Interval;

        return $this->type;
    }

    public function getFirstNote(): NoteEnum
    {
        return $this->firstNote;
    }

    public function setFirstNote(NoteEnum $firstNote): self
    {
        $this->firstNote = $firstNote;

        return $this;
    }

    public function getSecondNote(): NoteEnum
    {
        return NoteEnum::fromInt(NoteEnum::getIndex($this->firstNote) + IntervalEnum::getHalfSteps($this->intervalType));
    }

    public function getSecondNoteIndex(): int
    {
        return NoteEnum::getIndex($this->getSecondNote());
    }

    public function getIntervalType(): IntervalEnum
    {
        return $this->intervalType;
    }

    public function setIntervalType(IntervalEnum $intervalType): self
    {
        $this->intervalType = $intervalType;

        return $this;
    }


    public function isHarmonic(): bool
    {
        return $this->isHarmonic;
    }

    public function setIsHarmonic(bool $isHarmonic): self
    {
        $this->isHarmonic = $isHarmonic;

        return $this;
    }
}