<?php

namespace App\Entity\Task;

use App\Entity\Enum\NoteEnum;
use App\Entity\Enum\TaskTypeEnum;
use App\Repository\RelativePitchSoundRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RelativePitchSoundRepository::class)]
class RelativePitchSound extends AbstractTask
{
    public function __construct()
    {
        $this->type = TaskTypeEnum::RelativePitchSound;
    }

    #[ORM\Column(type: 'string', length: 3, enumType: NoteEnum::class)]
    private ?NoteEnum $firstNote = null;
    #[ORM\Column(type: 'string', length: 3, enumType: NoteEnum::class)]
    private ?NoteEnum $secondNote = null;

    public function getType(): TaskTypeEnum
    {
        $this->type = TaskTypeEnum::RelativePitchSound;

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
}