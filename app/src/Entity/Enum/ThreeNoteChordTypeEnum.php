<?php

namespace App\Entity\Enum;

use Symfony\Contracts\Translation\TranslatorInterface;

enum ThreeNoteChordTypeEnum: string
{
    case Major = 'Major';
    case Minor = 'Minor';
    case Diminished = 'Diminished';
    case Augmented = 'Augmented';

    public static function options(): array
    {
        return [
            self::Major,
            self::Minor,
            self::Diminished,
            self::Augmented,
        ];
    }

    public static function translatedOptions(TranslatorInterface $translator): array
    {
        return array_map(fn(self $option) => $translator->trans('ui.threeNoteChordType.' . $option->value), self::options());
    }

    public function trans(TranslatorInterface $translator): string
    {
        return $translator->trans('ui.threeNoteChordType.' . $this->value);
    }
}