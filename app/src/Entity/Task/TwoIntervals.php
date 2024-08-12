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
    #[ORM\Column(type: 'string', length: 3, enumType: NoteEnum::class)]
    private ?NoteEnum $thirdNote = null;
    #[ORM\Column(type: 'string', length: 3, enumType: NoteEnum::class)]
    private ?NoteEnum $fourthNote = null;
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

    public function getThirdNote(): NoteEnum
    {
        return $this->thirdNote;
    }

    public function setThirdNote(NoteEnum $thirdNote): self
    {
        $this->thirdNote = $thirdNote;

        return $this;
    }

    public function getFourthNote(): NoteEnum
    {
        return $this->fourthNote;
    }

    public function setFourthNote(NoteEnum $fourthNote): self
    {
        $this->fourthNote = $fourthNote;

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

    public function getFirstInterval(): IntervalEnum
    {
        return NoteUtils::getIntervalBetweenNotes($this->firstNote, $this->secondNote);
    }

    public function getSecondInterval(): IntervalEnum
    {
        return NoteUtils::getIntervalBetweenNotes($this->thirdNote, $this->fourthNote);
    }

    public function getSemitonesForFirstInterval(): int
    {
        return NoteUtils::countSemitonesBetweenNotes($this->firstNote, $this->secondNote);
    }

    public function getSemitonesForSecondInterval(): int
    {
        return NoteUtils::countSemitonesBetweenNotes($this->thirdNote, $this->fourthNote);
    }
}