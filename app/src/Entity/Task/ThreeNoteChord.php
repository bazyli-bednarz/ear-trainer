<?php

namespace App\Entity\Task;

use App\Entity\Enum\InversionTypeEnum;
use App\Entity\Enum\NoteEnum;
use App\Entity\Enum\TaskTypeEnum;
use App\Entity\Enum\ThreeNoteChordTypeEnum;
use App\Entity\Utils\NoteUtils;
use App\Repository\ThreeNoteChordRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThreeNoteChordRepository::class)]
class ThreeNoteChord extends AbstractTask
{
    public function __construct()
    {
        $this->type = TaskTypeEnum::ThreeNoteChord;
    }

    #[ORM\Column(type: 'string', length: 3, enumType: NoteEnum::class)]
    private ?NoteEnum $firstNote = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $isHarmonic = null;
    #[ORM\Column(type: 'string', length: 20, enumType: ThreeNoteChordTypeEnum::class)]
    private ?ThreeNoteChordTypeEnum $chord = null;

    #[ORM\Column(type: 'string', length: 20, enumType: InversionTypeEnum::class)]
    private ?InversionTypeEnum $inversion = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $shouldStudentRecogniseInversion = null;

    public function getType(): TaskTypeEnum
    {
        $this->type = TaskTypeEnum::ThreeNoteChord;

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

    public function getChord(): ThreeNoteChordTypeEnum
    {
        return $this->chord;
    }

    public function setChord(ThreeNoteChordTypeEnum $chord): self
    {
        $this->chord = $chord;

        return $this;
    }

    public function getInversion(): InversionTypeEnum
    {
        return $this->inversion;
    }

    public function setInversion(InversionTypeEnum $inversion): self
    {
        $this->inversion = $inversion;

        return $this;
    }

    public function getShouldStudentRecogniseInversion(): bool
    {
        return $this->shouldStudentRecogniseInversion;
    }

    public function setShouldStudentRecogniseInversion(bool $shouldStudentRecogniseInversion): self
    {
        $this->shouldStudentRecogniseInversion = $shouldStudentRecogniseInversion;

        return $this;
    }

    public function getNotes(): array
    {
        return [
            $this->firstNote,
            NoteUtils::getThirdNoteInThreeNoteChordWithInversion($this->firstNote, $this->chord, $this->inversion),
            NoteUtils::getFifthNoteInThreeNoteChordWithInversion($this->firstNote, $this->chord, $this->inversion),
        ];
    }
}