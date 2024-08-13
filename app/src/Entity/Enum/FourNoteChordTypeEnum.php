<?php

namespace App\Entity\Enum;

use Symfony\Contracts\Translation\TranslatorInterface;

enum FourNoteChordTypeEnum: string
{
    case Dominant7 = 'Dominant7';
    case MajorMajor7 = 'MajorMajor7';
    case MinorMinor7 = 'MinorMinor7';
    case MinorMajor7 = 'MinorMajor7';


    public static function options(): array
    {
        return [
            self::Dominant7,
            self::MajorMajor7,
            self::MinorMinor7,
            self::MinorMajor7,
        ];
    }

    public static function translatedOptions(TranslatorInterface $translator): array
    {
        return array_map(fn(self $option) => $translator->trans('ui.fourNoteChordType.' . $option->value), self::options());
    }

    public function trans(TranslatorInterface $translator): string
    {
        return $translator->trans('ui.fourNoteChordType.' . $this->value);
    }
}