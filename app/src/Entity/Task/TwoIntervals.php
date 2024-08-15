<?php

namespace App\Entity\Task;

use App\Entity\Enum\IntervalEnum;
use App\Entity\Enum\NoteEnum;
use App\Entity\Enum\TaskTypeEnum;
use App\Entity\Enum\TwoIntervalsTypeEnum;
use App\Entity\Utils\NoteUtils;
use App\Repository\IntervalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IntervalRepository::class)]
class TwoIntervals extends AbstractTask
{
    public function __construct()
    {
        $this->type = TaskTypeEnum::TwoIntervals;
    }

    #[ORM\Column(type: 'string', length: 3, enumType: NoteEnum::class)]
    private ?NoteEnum $firstNote = null;
    #[ORM\Column(type: 'string', length: 3, enumType: NoteEnum::class)]
    private ?NoteEnum $secondNote = null;
    #[ORM\Column(type: 'string', length: 30, enumType: IntervalEnum::class)]
    private ?IntervalEnum $firstIntervalType = null;
    #[ORM\Column(type: 'string', length: 30, enumType: IntervalEnum::class)]
    private ?IntervalEnum $secondIntervalType = null;
    #[ORM\Column(type: 'boolean')]
    private ?bool $isFirstHarmonic = null;
    #[ORM\Column(type: 'boolean')]
    private ?bool $isSecondHarmonic = null;
    #[ORM\Column(type: 'string', length: 20, enumType: TwoIntervalsTypeEnum::class)]
    private ?TwoIntervalsTypeEnum $twoIntervalsTypeEnum = null;

    public function getType(): TaskTypeEnum
    {
        $this->type = TaskTypeEnum::TwoIntervals;

        return $this->type;
    }

    public function getFirstNote(): NoteEnum
    {
        return $this->firstNote;
    }

    public function getFirstNoteIndex(): int
    {
        return NoteEnum::getIndex($this->getFirstNote());
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

    public function getSecondNoteIndex(): int
    {
        return NoteEnum::getIndex($this->getSecondNote());
    }

    public function setSecondNote(NoteEnum $secondNote): self
    {
        $this->secondNote = $secondNote;

        return $this;
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

    public function getUpperEdgeIntervalType(): IntervalEnum
    {
        return IntervalEnum::fromInt(abs($this->getThirdNoteIndex() - $this->getFourthNoteIndex()));
    }

    public function getLowerEdgeIntervalType(): IntervalEnum
    {
        return IntervalEnum::fromInt(abs($this->getFirstNoteIndex() - $this->getSecondNoteIndex()));
    }

    public function getFirstIntervalType(): IntervalEnum
    {
        return $this->firstIntervalType;
    }

    public function setFirstIntervalType(IntervalEnum $firstIntervalType): self
    {
        $this->firstIntervalType = $firstIntervalType;

        return $this;
    }

    public function getSecondIntervalType(): IntervalEnum
    {
        return $this->secondIntervalType;
    }

    public function setSecondIntervalType(IntervalEnum $secondIntervalType): self
    {
        $this->secondIntervalType = $secondIntervalType;

        return $this;
    }

    public function isFirstHarmonic(): bool
    {
        return $this->isFirstHarmonic;
    }

    public function setIsFirstHarmonic(bool $isFirstHarmonic): self
    {
        $this->isFirstHarmonic = $isFirstHarmonic;

        return $this;
    }

    public function isSecondHarmonic(): bool
    {
        return $this->isSecondHarmonic;
    }

    public function setIsSecondHarmonic(bool $isSecondHarmonic): self
    {
        $this->isSecondHarmonic = $isSecondHarmonic;

        return $this;
    }

    public function getTwoIntervalsTypeEnum(): TwoIntervalsTypeEnum
    {
        return $this->twoIntervalsTypeEnum;
    }

    public function setTwoIntervalsTypeEnum(TwoIntervalsTypeEnum $twoIntervalsTypeEnum): self
    {
        $this->twoIntervalsTypeEnum = $twoIntervalsTypeEnum;

        return $this;
    }
}