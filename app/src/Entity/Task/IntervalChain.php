<?php

namespace App\Entity\Task;

use App\Entity\Enum\IntervalEnum;
use App\Entity\Enum\NoteEnum;
use App\Entity\Enum\TaskTypeEnum;
use App\Repository\IntervalChainRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IntervalChainRepository::class)]
class IntervalChain extends AbstractTask
{
    public function __construct()
    {
        $this->type = TaskTypeEnum::IntervalChain;
    }

    #[ORM\Column(type: 'string', length: 3, enumType: NoteEnum::class)]
    private ?NoteEnum $firstNote = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $isHarmonic = null;
    #[ORM\Column(type: 'string', length: 30, enumType: IntervalEnum::class)]
    private ?IntervalEnum $intervalType = null;

    public function getType(): TaskTypeEnum
    {
        $this->type = TaskTypeEnum::IntervalChain;

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

    public function getNthNote(int $n): ?NoteEnum
    {
        if ($n < 1) {
            throw new \InvalidArgumentException('n must be greater than 0');
        }
        try {
            return NoteEnum::fromInt(NoteEnum::getIndex($this->firstNote) + (IntervalEnum::getHalfSteps($this->intervalType)) * ($n - 1));
        } catch (\Exception $e) {
            return null;
        }
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

    public function getIntervalType(): IntervalEnum
    {
        return $this->intervalType;
    }

    public function setIntervalType(IntervalEnum $intervalType): self
    {
        $this->intervalType = $intervalType;

        return $this;
    }
}