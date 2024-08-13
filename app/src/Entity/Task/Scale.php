<?php

namespace App\Entity\Task;

use App\Entity\Enum\NoteEnum;
use App\Entity\Enum\ScaleTypeEnum;
use App\Entity\Enum\TaskTypeEnum;
use App\Entity\Utils\NoteUtils;
use App\Repository\ScaleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScaleRepository::class)]
class Scale extends AbstractTask
{
    public function __construct()
    {
        $this->type = TaskTypeEnum::Scale;
    }

    #[ORM\Column(type: 'string', length: 3, enumType: NoteEnum::class)]
    private ?NoteEnum $firstNote = null;
    #[ORM\Column(type: 'string', length: 20, enumType: ScaleTypeEnum::class)]
    private ?ScaleTypeEnum $scaleType = null;


    public function getType(): TaskTypeEnum
    {
        $this->type = TaskTypeEnum::Scale;

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

    public function getScaleType(): ScaleTypeEnum
    {
        return $this->scaleType;
    }

    public function setScaleType(ScaleTypeEnum $scaleType): self
    {
        $this->scaleType = $scaleType;

        return $this;
    }

    public function getNotes(): array
    {
        return NoteUtils::getNotesForScale($this->firstNote, $this->scaleType);
    }
}