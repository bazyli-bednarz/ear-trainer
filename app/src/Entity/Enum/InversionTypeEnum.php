<?php

namespace App\Entity\Enum;

use Symfony\Contracts\Translation\TranslatorInterface;

enum InversionTypeEnum: string
{
    case NoInversion = 'NoInversion';
    case FirstInversion = 'FirstInversion';
    case SecondInversion = 'SecondInversion';
    case ThirdInversion = 'ThirdInversion';

    public static function threeNoteChordOptions(): array
    {
        return [
            self::NoInversion,
            self::FirstInversion,
            self::SecondInversion,
        ];
    }

    public static function fourNoteChordOptions(): array
    {
        return [
            self::NoInversion,
            self::FirstInversion,
            self::SecondInversion,
            self::ThirdInversion,
        ];
    }

    public static function translatedOptions(TranslatorInterface $translator): array
    {
        return array_map(fn(self $option) => $translator->trans('ui.inversion.' . $option->value), self::options());
    }

    public function trans(TranslatorInterface $translator): string
    {
        return $translator->trans('ui.inversion.' . $this->value);
    }
}