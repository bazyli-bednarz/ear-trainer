<?php

namespace App\Dto\TaskAnswer;

use App\Entity\Enum\FourNoteChordTypeEnum;
use App\Entity\Enum\IntervalEnum;
use App\Entity\Enum\InversionTypeEnum;
use App\Entity\Enum\RelativePitchSoundAnswerEnum;
use App\Entity\Enum\ScaleTypeEnum;
use App\Entity\Enum\ThreeNoteChordTypeEnum;
use App\Form\Type\Task\FourNoteChordType;

class TaskAnswerDto
{
    private ?RelativePitchSoundAnswerEnum $relativePitchSoundAnswer;
    private ?IntervalEnum $intervalAnswer;
    private ?IntervalEnum $firstIntervalAnswer;
    private ?IntervalEnum $secondIntervalAnswer;
    private ?IntervalEnum $upperEdgeIntervalAnswer;
    private ?IntervalEnum $lowerEdgeIntervalAnswer;
    private ?ThreeNoteChordTypeEnum $threeNoteChordAnswer;
    private ?InversionTypeEnum $inversionAnswer = null;
    private ?ScaleTypeEnum $scaleAnswer;

    private ?FourNoteChordTypeEnum $fourNoteChordAnswer;

    public function getRelativePitchSoundAnswer(): ?RelativePitchSoundAnswerEnum
    {
        return $this->relativePitchSoundAnswer;
    }

    public function setRelativePitchSoundAnswer(?RelativePitchSoundAnswerEnum $relativePitchSoundAnswer): self
    {
        $this->relativePitchSoundAnswer = $relativePitchSoundAnswer;
        return $this;
    }

    public function getIntervalAnswer(): ?IntervalEnum
    {
        return $this->intervalAnswer;
    }

    public function setIntervalAnswer(?IntervalEnum $intervalAnswer): self
    {
        $this->intervalAnswer = $intervalAnswer;
        return $this;
    }

    public function getFirstIntervalAnswer(): ?IntervalEnum
    {
        return $this->firstIntervalAnswer;
    }

    public function setFirstIntervalAnswer(?IntervalEnum $firstIntervalAnswer): self
    {
        $this->firstIntervalAnswer = $firstIntervalAnswer;
        return $this;
    }

    public function getSecondIntervalAnswer(): ?IntervalEnum
    {
        return $this->secondIntervalAnswer;
    }

    public function setSecondIntervalAnswer(?IntervalEnum $secondIntervalAnswer): self
    {
        $this->secondIntervalAnswer = $secondIntervalAnswer;
        return $this;
    }

    public function getUpperEdgeIntervalAnswer(): ?IntervalEnum
    {
        return $this->upperEdgeIntervalAnswer;
    }

    public function setUpperEdgeIntervalAnswer(?IntervalEnum $upperEdgeIntervalAnswer): self
    {
        $this->upperEdgeIntervalAnswer = $upperEdgeIntervalAnswer;
        return $this;
    }

    public function getLowerEdgeIntervalAnswer(): ?IntervalEnum
    {
        return $this->lowerEdgeIntervalAnswer;
    }

    public function setLowerEdgeIntervalAnswer(?IntervalEnum $lowerEdgeIntervalAnswer): self
    {
        $this->lowerEdgeIntervalAnswer = $lowerEdgeIntervalAnswer;
        return $this;
    }

    public function getThreeNoteChordAnswer(): ?ThreeNoteChordTypeEnum
    {
        return $this->threeNoteChordAnswer;
    }

    public function setThreeNoteChordAnswer(?ThreeNoteChordTypeEnum $threeNoteChordAnswer): self
    {
        $this->threeNoteChordAnswer = $threeNoteChordAnswer;
        return $this;
    }

    public function getInversionAnswer(): ?InversionTypeEnum
    {
        return $this->inversionAnswer;
    }

    public function setInversionAnswer(?InversionTypeEnum $inversionAnswer): self
    {
        $this->inversionAnswer = $inversionAnswer;
        return $this;
    }

    public function getFourNoteChordAnswer(): ?FourNoteChordTypeEnum
    {
        return $this->fourNoteChordAnswer;
    }

    public function setFourNoteChordAnswer(?FourNoteChordTypeEnum $fourNoteChordAnswer): self
    {
        $this->fourNoteChordAnswer = $fourNoteChordAnswer;
        return $this;
    }

    public function getScaleAnswer(): ?ScaleTypeEnum
    {
        return $this->scaleAnswer;
    }

    public function setScaleAnswer(?ScaleTypeEnum $scaleAnswer): self
    {
        $this->scaleAnswer = $scaleAnswer;
        return $this;
    }
}