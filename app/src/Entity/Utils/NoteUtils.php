<?php

namespace App\Entity\Utils;

use App\Entity\Enum\FourNoteChordTypeEnum;
use App\Entity\Enum\IntervalEnum;
use App\Entity\Enum\InversionTypeEnum;
use App\Entity\Enum\NoteEnum;
use App\Entity\Enum\ScaleTypeEnum;
use App\Entity\Enum\ThreeNoteChordTypeEnum;
use App\Entity\Task\ThreeNoteChord;
use Exception;

class NoteUtils
{
    public static function countSemitonesBetweenNotes(NoteEnum $note1, NoteEnum $note2): int
    {
        $note1Index = array_search($note1->value, NoteEnum::options());
        $note2Index = array_search($note2->value, NoteEnum::options());

        return abs($note1Index - $note2Index);
    }

    public static function getIntervalBetweenNotes(NoteEnum $note1, NoteEnum $note2): IntervalEnum
    {
        $interval = self::countSemitonesBetweenNotes($note1, $note2);
        return IntervalEnum::from($interval);
    }

    public static function getSecondNoteInThreeNoteChordWithInversion(NoteEnum $note, ThreeNoteChordTypeEnum $chord, InversionTypeEnum $inversion): ?NoteEnum
    {
        try {

            $noteIndex = array_search($note->value, NoteEnum::options());

            if ($inversion === InversionTypeEnum::NoInversion) {
                $interval = match ($chord) {
                    ThreeNoteChordTypeEnum::Major => 4,
                    ThreeNoteChordTypeEnum::Minor => 3,
                    ThreeNoteChordTypeEnum::Diminished => 3,
                    ThreeNoteChordTypeEnum::Augmented => 4,
                };
            }
            if ($inversion === InversionTypeEnum::FirstInversion) {
                $interval = match ($chord) {
                    ThreeNoteChordTypeEnum::Major => 3,
                    ThreeNoteChordTypeEnum::Minor => 4,
                    ThreeNoteChordTypeEnum::Diminished => 3,
                    ThreeNoteChordTypeEnum::Augmented => 4,
                };
            }
            if ($inversion === InversionTypeEnum::SecondInversion) {
                $interval = match ($chord) {
                    ThreeNoteChordTypeEnum::Major => 5,
                    ThreeNoteChordTypeEnum::Minor => 5,
                    ThreeNoteChordTypeEnum::Diminished => 6,
                    ThreeNoteChordTypeEnum::Augmented => 4,
                };
            }

            $thirdNoteIndex = ($noteIndex + $interval) % count(NoteEnum::options());
            return NoteEnum::from(NoteEnum::options()[$thirdNoteIndex]->value);
        } catch (Exception $e) {
            return null;
        }

    }

    public static function getThirdNoteInThreeNoteChordWithInversion(NoteEnum $note, ThreeNoteChordTypeEnum $chord, InversionTypeEnum $inversion): ?NoteEnum
    {
        try {

            $noteIndex = array_search($note->value, NoteEnum::options());

            if ($inversion === InversionTypeEnum::NoInversion) {
                $interval = match ($chord) {
                    ThreeNoteChordTypeEnum::Major => 7,
                    ThreeNoteChordTypeEnum::Minor => 7,
                    ThreeNoteChordTypeEnum::Diminished => 6,
                    ThreeNoteChordTypeEnum::Augmented => 8,
                };
            }
            if ($inversion === InversionTypeEnum::FirstInversion) {
                $interval = match ($chord) {
                    ThreeNoteChordTypeEnum::Major => 8,
                    ThreeNoteChordTypeEnum::Minor => 9,
                    ThreeNoteChordTypeEnum::Diminished => 9,
                    ThreeNoteChordTypeEnum::Augmented => 8,
                };
            }
            if ($inversion === InversionTypeEnum::SecondInversion) {
                $interval = match ($chord) {
                    ThreeNoteChordTypeEnum::Major => 9,
                    ThreeNoteChordTypeEnum::Minor => 8,
                    ThreeNoteChordTypeEnum::Diminished => 9,
                    ThreeNoteChordTypeEnum::Augmented => 9,
                };
            }

            $thirdNoteIndex = ($noteIndex + $interval) % count(NoteEnum::options());
            return NoteEnum::from(NoteEnum::options()[$thirdNoteIndex]->value);
        } catch (Exception $e) {
            return null;
        }

    }

    public static function getSecondNoteInFourNoteChord(NoteEnum $note, FourNoteChordTypeEnum $chord): ?NoteEnum
    {
        try {
            $noteIndex = array_search($note->value, NoteEnum::options());

            $interval = match ($chord) {
                FourNoteChordTypeEnum::Dominant7 => 4,
                FourNoteChordTypeEnum::MajorMajor7 => 4,
                FourNoteChordTypeEnum::MinorMinor7 => 3,
                FourNoteChordTypeEnum::MinorMajor7 => 3,
            };

            $secondNoteIndex = ($noteIndex + $interval) % count(NoteEnum::options());
            return NoteEnum::from(NoteEnum::options()[$secondNoteIndex]->value);
        } catch (Exception $e) {
            return null;
        }
    }

    public static function getThirdNoteInFourNoteChord(NoteEnum $note, FourNoteChordTypeEnum $chord): ?NoteEnum
    {
        try {
            $noteIndex = array_search($note->value, NoteEnum::options());

            $interval = match ($chord) {
                FourNoteChordTypeEnum::Dominant7 => 7,
                FourNoteChordTypeEnum::MajorMajor7 => 7,
                FourNoteChordTypeEnum::MinorMinor7 => 7,
                FourNoteChordTypeEnum::MinorMajor7 => 7,
            };

            $secondNoteIndex = ($noteIndex + $interval) % count(NoteEnum::options());
            return NoteEnum::from(NoteEnum::options()[$secondNoteIndex]->value);
        } catch (Exception $e) {
            return null;
        }
    }

    public static function getFourthNoteInFourNoteChord(NoteEnum $note, FourNoteChordTypeEnum $chord): ?NoteEnum
    {
        try {
            $noteIndex = array_search($note->value, NoteEnum::options());

            $interval = match ($chord) {
                FourNoteChordTypeEnum::Dominant7 => 10,
                FourNoteChordTypeEnum::MajorMajor7 => 11,
                FourNoteChordTypeEnum::MinorMinor7 => 10,
                FourNoteChordTypeEnum::MinorMajor7 => 11,
            };

            $secondNoteIndex = ($noteIndex + $interval) % count(NoteEnum::options());
            return NoteEnum::from(NoteEnum::options()[$secondNoteIndex]->value);
        } catch (Exception $e) {
            return null;
        }
    }

    public static function getNotesForScale(NoteEnum $firstNote, ScaleTypeEnum $scale): array
    {
        $utils = new NoteUtils();
        switch ($scale) {
            case ScaleTypeEnum::Major:
                return [
                    $firstNote,
                    $utils->addSemitones($firstNote, 2),
                    $utils->addSemitones($firstNote, 4),
                    $utils->addSemitones($firstNote, 5),
                    $utils->addSemitones($firstNote, 7),
                    $utils->addSemitones($firstNote, 9),
                    $utils->addSemitones($firstNote, 11),
                    $utils->addSemitones($firstNote, 12),
                ];
            case ScaleTypeEnum::Minor:
                return [
                    $firstNote,
                    $utils->addSemitones($firstNote, 2),
                    $utils->addSemitones($firstNote, 3),
                    $utils->addSemitones($firstNote, 5),
                    $utils->addSemitones($firstNote, 7),
                    $utils->addSemitones($firstNote, 8),
                    $utils->addSemitones($firstNote, 10),
                    $utils->addSemitones($firstNote, 12),
                ];
            case ScaleTypeEnum::HarmonicMinor:
                return [
                    $firstNote,
                    $utils->addSemitones($firstNote, 2),
                    $utils->addSemitones($firstNote, 3),
                    $utils->addSemitones($firstNote, 5),
                    $utils->addSemitones($firstNote, 7),
                    $utils->addSemitones($firstNote, 8),
                    $utils->addSemitones($firstNote, 11),
                    $utils->addSemitones($firstNote, 12),
                ];
            case ScaleTypeEnum::MelodicMinor:
                return [
                    $firstNote,
                    $utils->addSemitones($firstNote, 2),
                    $utils->addSemitones($firstNote, 3),
                    $utils->addSemitones($firstNote, 5),
                    $utils->addSemitones($firstNote, 7),
                    $utils->addSemitones($firstNote, 9),
                    $utils->addSemitones($firstNote, 11),
                    $utils->addSemitones($firstNote, 12),
                ];
            case ScaleTypeEnum::MajorPentatonic:
                return [
                    $firstNote,
                    $utils->addSemitones($firstNote, 2),
                    $utils->addSemitones($firstNote, 4),
                    $utils->addSemitones($firstNote, 7),
                    $utils->addSemitones($firstNote, 9),
                    $utils->addSemitones($firstNote, 12),
                ];
            case ScaleTypeEnum::MinorPentatonic:
                return [
                    $firstNote,
                    $utils->addSemitones($firstNote, 3),
                    $utils->addSemitones($firstNote, 5),
                    $utils->addSemitones($firstNote, 7),
                    $utils->addSemitones($firstNote, 10),
                    $utils->addSemitones($firstNote, 12),
                ];
            case ScaleTypeEnum::Blues:
                return [
                    $firstNote,
                    $utils->addSemitones($firstNote, 3),
                    $utils->addSemitones($firstNote, 5),
                    $utils->addSemitones($firstNote, 6),
                    $utils->addSemitones($firstNote, 7),
                    $utils->addSemitones($firstNote, 10),
                    $utils->addSemitones($firstNote, 12),
                ];
            case ScaleTypeEnum::WholeTone:
                return [
                    $firstNote,
                    $utils->addSemitones($firstNote, 2),
                    $utils->addSemitones($firstNote, 4),
                    $utils->addSemitones($firstNote, 6),
                    $utils->addSemitones($firstNote, 8),
                    $utils->addSemitones($firstNote, 10),
                    $utils->addSemitones($firstNote, 12),
                ];
            case ScaleTypeEnum::Chromatic:
                return [
                    $firstNote,
                    $utils->addSemitones($firstNote, 1),
                    $utils->addSemitones($firstNote, 2),
                    $utils->addSemitones($firstNote, 3),
                    $utils->addSemitones($firstNote, 4),
                    $utils->addSemitones($firstNote, 5),
                    $utils->addSemitones($firstNote, 6),
                    $utils->addSemitones($firstNote, 7),
                    $utils->addSemitones($firstNote, 8),
                    $utils->addSemitones($firstNote, 9),
                    $utils->addSemitones($firstNote, 10),
                    $utils->addSemitones($firstNote, 11),
                    $utils->addSemitones($firstNote, 12),
                ];
            default:
                return [];
        }
    }

    private function addSemitones(NoteEnum $note, int $semitones): NoteEnum
    {
        return NoteEnum::from(NoteEnum::options()[(array_search($note->value, NoteEnum::options()) + $semitones) % count(NoteEnum::options())]->value);
    }

}