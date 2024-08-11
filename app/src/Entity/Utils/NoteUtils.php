<?php

namespace App\Entity\Utils;

use App\Entity\Enum\IntervalEnum;
use App\Entity\Enum\NoteEnum;

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
}