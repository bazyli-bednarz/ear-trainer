<?php

namespace App\Entity\Task;

use App\Entity\Enum\IntervalEnum;
use App\Entity\Enum\NoteEnum;
use App\Entity\Enum\TaskTypeEnum;
use App\Entity\Utils\NoteUtils;
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
    #[ORM\Column(type: 'string', length: 3, enumType: NoteEnum::class)]
    private ?NoteEnum $secondNote = null;
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
        return $this->secondNote;
    }

    public function setSecondNote(NoteEnum $secondNote): self
    {
        $this->secondNote = $secondNote;

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

    public function getInterval(): IntervalEnum
    {
        return NoteUtils::getIntervalBetweenNotes($this->firstNote, $this->secondNote);
    }

    public function getSemitones(): int
    {
        return NoteUtils::countSemitonesBetweenNotes($this->firstNote, $this->secondNote);
    }
}