<?php

namespace App\Entity\Enum;

use Symfony\Contracts\Translation\TranslatorInterface;

enum ScaleTypeEnum: string
{
    case Major = 'Major';
    case Minor = 'Minor';
    case HarmonicMinor = 'HarmonicMinor';
    case MelodicMinor = 'MelodicMinor';
    case MajorPentatonic = 'MajorPentatonic';
    case MinorPentatonic = 'MinorPentatonic';
    case Blues = 'Blues';
    case WholeTone = 'WholeTone';
    case Chromatic = 'Chromatic';


    public static function options(): array
    {
        return [
            self::Major,
            self::Minor,
            self::HarmonicMinor,
            self::MelodicMinor,
            self::MajorPentatonic,
            self::MinorPentatonic,
            self::Blues,
            self::WholeTone,
            self::Chromatic,
        ];
    }

    public static function translatedOptions(TranslatorInterface $translator): array
    {
        return array_map(fn(self $option) => $translator->trans('ui.scaleType.' . $option->value), self::options());
    }

    public function trans(TranslatorInterface $translator): string
    {
        return $translator->trans('ui.scaleType.' . $this->value);
    }
}