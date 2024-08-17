<?php

namespace App\Entity\Enum;

use Symfony\Contracts\Translation\TranslatorInterface;

enum AwardEnum: string
{
    case CompletedFirstTask = 'CompletedFirstTask';
    case CompletedFirstNode = 'CompletedFirstNode';
    case CompletedFirstCourse = 'CompletedFirstCourse';

    public static function getPoints(self $award): int
    {
        return match ($award) {
            self::CompletedFirstTask => 30,
            self::CompletedFirstNode => 50,
            self::CompletedFirstCourse => 100,
        };
    }

    public static function getIcon(self $award): string
    {
        return match ($award) {
            self::CompletedFirstTask => 'bi bi-award-fill',
            self::CompletedFirstNode => 'fa-solid fa-medal',
            self::CompletedFirstCourse => 'fa-solid fa-trophy',
        };
    }

    public function trans(TranslatorInterface $translator): string
    {
        return $translator->trans('ui.award.' . $this->value);
    }

}