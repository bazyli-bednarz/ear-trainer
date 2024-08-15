<?php

namespace App\Entity\Enum;

use Symfony\Contracts\Translation\TranslatorInterface;

enum RelativePitchSoundAnswerEnum: string
{
    case FirstHigher = 'FirstHigher';
    case SecondHigher = 'SecondHigher';
    case Equal = 'Equal';

    public static function options(): array
    {
        return [
            self::FirstHigher,
            self::SecondHigher,
            self::Equal,
        ];
    }


    public function trans(TranslatorInterface $translator): string
    {
        return $translator->trans('ui.relativePitchSoundAnswer.' . $this->value);
    }
}