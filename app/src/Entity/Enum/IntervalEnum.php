<?php

namespace App\Entity\Enum;

use Symfony\Contracts\Translation\TranslatorInterface;

enum IntervalEnum: string
{
    case PerfectUnison = 'PerfectUnison';
    case MinorSecond = 'MinorSecond';
    case MajorSecond = 'MajorSecond';
    case MinorThird = 'MinorThird';
    case MajorThird = 'MajorThird';
    case PerfectFourth = 'PerfectFourth';
    case Tritone = 'Tritone';
    case PerfectFifth = 'PerfectFifth';
    case MinorSixth = 'MinorSixth';
    case MajorSixth = 'MajorSixth';
    case MinorSeventh = 'MinorSeventh';
    case MajorSeventh = 'MajorSeventh';
    case PerfectOctave = 'PerfectOctave';
    case MinorNinth = 'MinorNinth';
    case MajorNinth = 'MajorNinth';
    case MinorTenth = 'MinorTenth';
    case MajorTenth = 'MajorTenth';
    case PerfectEleventh = 'PerfectEleventh';
    case AugmentedEleventh = 'AugmentedEleventh';
    case PerfectTwelfth = 'PerfectTwelfth';
    case MinorThirteenth = 'MinorThirteenth';
    case MajorThirteenth = 'MajorThirteenth';
    case MinorFourteenth = 'MinorFourteenth';
    case MajorFourteenth = 'MajorFourteenth';
    case PerfectFifteenth = 'PerfectFifteenth';

    const STRING_TO_INT_MAPPING = [
        'PerfectUnison' => 0,
        'MinorSecond' => 1,
        'MajorSecond' => 2,
        'MinorThird' => 3,
        'MajorThird' => 4,
        'PerfectFourth' => 5,
        'Tritone' => 6,
        'PerfectFifth' => 7,
        'MinorSixth' => 8,
        'MajorSixth' => 9,
        'MinorSeventh' => 10,
        'MajorSeventh' => 11,
        'PerfectOctave' => 12,
        'MinorNinth' => 13,
        'MajorNinth' => 14,
        'MinorTenth' => 15,
        'MajorTenth' => 16,
        'PerfectEleventh' => 17,
        'AugmentedEleventh' => 18,
        'PerfectTwelfth' => 19,
        'MinorThirteenth' => 20,
        'MajorThirteenth' => 21,
        'MinorFourteenth' => 22,
        'MajorFourteenth' => 23,
        'PerfectFifteenth' => 24,
    ];

    public static function options(): array
    {
        return [
            self::PerfectUnison,
            self::MinorSecond,
            self::MajorSecond,
            self::MinorThird,
            self::MajorThird,
            self::PerfectFourth,
            self::Tritone,
            self::PerfectFifth,
            self::MinorSixth,
            self::MajorSixth,
            self::MinorSeventh,
            self::MajorSeventh,
            self::PerfectOctave,
            self::MinorNinth,
            self::MajorNinth,
            self::MinorTenth,
            self::MajorTenth,
            self::PerfectEleventh,
            self::AugmentedEleventh,
            self::PerfectTwelfth,
            self::MinorThirteenth,
            self::MajorThirteenth,
            self::MinorFourteenth,
            self::MajorFourteenth,
            self::PerfectFifteenth,
        ];
    }

    public static function simpleIntervalsOptions(): array
    {
        return [
            self::PerfectUnison,
            self::MinorSecond,
            self::MajorSecond,
            self::MinorThird,
            self::MajorThird,
            self::PerfectFourth,
            self::Tritone,
            self::PerfectFifth,
            self::MinorSixth,
            self::MajorSixth,
            self::MinorSeventh,
            self::MajorSeventh,
            self::PerfectOctave,
        ];
    }

    public static function optionsForIntervalChain(): array
    {
        return [
            self::MinorSecond,
            self::MajorSecond,
            self::MinorThird,
            self::MajorThird,
            self::PerfectFourth,
            self::Tritone,
            self::PerfectFifth,
        ];
    }

    public static function fromInt(int $interval): self
    {
       return self::from(
           array_flip(self::STRING_TO_INT_MAPPING)[$interval]
       );
    }

    public static function getHalfSteps(self $interval): int
    {
        return self::STRING_TO_INT_MAPPING[$interval->value];
    }

    public function trans(TranslatorInterface $translator): string
    {
        return $translator->trans('ui.interval.' . $this->value);
    }
}