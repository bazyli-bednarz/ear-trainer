<?php

namespace App\Entity\Utils;

use App\Entity\Enum\IntervalEnum;
use App\Entity\Enum\InversionTypeEnum;
use App\Entity\Enum\NoteEnum;
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

    public static function getThirdNoteInThreeNoteChordWithInversion(NoteEnum $note, ThreeNoteChordTypeEnum $chord, InversionTypeEnum $inversion): ?NoteEnum
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

    public static function getFifthNoteInThreeNoteChordWithInversion(NoteEnum $note, ThreeNoteChordTypeEnum $chord, InversionTypeEnum $inversion): ?NoteEnum
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





}