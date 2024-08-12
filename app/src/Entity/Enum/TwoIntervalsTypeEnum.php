<?php

namespace App\Entity\Enum;

use Symfony\Contracts\Translation\TranslatorInterface;

enum TwoIntervalsTypeEnum: string
{
    case Normal = 'Normal';
    case IntervalSquare = 'IntervalSquare';

    public static function options(): array
    {
        return [
            self::Normal,
            self::IntervalSquare,
        ];
    }

    public static function translatedOptions(TranslatorInterface $translator): array
    {
        return array_map(fn(self $option) => $translator->trans('ui.twoIntervalsType.' . $option->value), self::options());
    }

    public function trans(TranslatorInterface $translator): string
    {
        return $translator->trans('ui.twoIntervalsType.' . $this->value);
    }
}