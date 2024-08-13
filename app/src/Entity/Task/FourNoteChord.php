<?php

namespace App\Entity\Task;

use App\Entity\Enum\FourNoteChordTypeEnum;
use App\Entity\Enum\NoteEnum;
use App\Entity\Enum\TaskTypeEnum;
use App\Entity\Utils\NoteUtils;
use App\Repository\ThreeNoteChordRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThreeNoteChordRepository::class)]
class FourNoteChord extends AbstractTask
{
    public function __construct()
    {
        $this->type = TaskTypeEnum::FourNoteChord;
    }

    #[ORM\Column(type: 'string', length: 3, enumType: NoteEnum::class)]
    private ?NoteEnum $firstNote = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $isHarmonic = null;
    #[ORM\Column(type: 'string', length: 20, enumType: FourNoteChordTypeEnum::class)]
    private ?FourNoteChordTypeEnum $fourNoteChord = null;


    public function getType(): TaskTypeEnum
    {
        $this->type = TaskTypeEnum::FourNoteChord;

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

    public function isHarmonic(): bool
    {
        return $this->isHarmonic;
    }

    public function setIsHarmonic(bool $isHarmonic): self
    {
        $this->isHarmonic = $isHarmonic;

        return $this;
    }

    public function getFourNoteChord(): FourNoteChordTypeEnum
    {
        return $this->fourNoteChord;
    }

    public function setFourNoteChord(FourNoteChordTypeEnum $fourNoteChord): self
    {
        $this->fourNoteChord = $fourNoteChord;

        return $this;
    }

    public function getNotes(): array
    {
        return [
            $this->firstNote,
            NoteUtils::getSecondNoteInFourNoteChord($this->firstNote, $this->fourNoteChord),
            NoteUtils::getThirdNoteInFourNoteChord($this->firstNote, $this->fourNoteChord),
            NoteUtils::getFourthNoteInFourNoteChord($this->firstNote, $this->fourNoteChord)
        ];
    }

}