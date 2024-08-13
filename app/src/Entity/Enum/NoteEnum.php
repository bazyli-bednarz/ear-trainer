<?php

namespace App\Entity\Enum;

use Symfony\Contracts\Translation\TranslatorInterface;

enum NoteEnum: string
{
    case C3 = 'C3';
    case CSharp3 = 'C#3';
    case D3 = 'D3';
    case DSharp3 = 'D#3';
    case E3 = 'E3';
    case F3 = 'F3';
    case FSharp3 = 'F#3';
    case G3 = 'G3';
    case GSharp3 = 'G#3';
    case A3 = 'A3';
    case ASharp3 = 'A#3';
    case B3 = 'B3';
    case C4 = 'C4';
    case CSharp4 = 'C#4';
    case D4 = 'D4';
    case DSharp4 = 'D#4';
    case E4 = 'E4';
    case F4 = 'F4';
    case FSharp4 = 'F#4';
    case G4 = 'G4';
    case GSharp4 = 'G#4';
    case A4 = 'A4';
    case ASharp4 = 'A#4';
    case B4 = 'B4';
    case C5 = 'C5';
    case CSharp5 = 'C#5';
    case D5 = 'D5';
    case DSharp5 = 'D#5';
    case E5 = 'E5';
    case F5 = 'F5';
    case FSharp5 = 'F#5';
    case G5 = 'G5';
    case GSharp5 = 'G#5';
    case A5 = 'A5';
    case ASharp5 = 'A#5';
    case B5 = 'B5';
    case C6 = 'C6';
    case CSharp6 = 'C#6';
    case D6 = 'D6';
    case DSharp6 = 'D#6';
    case E6 = 'E6';
    case F6 = 'F6';
    case FSharp6 = 'F#6';
    case G6 = 'G6';
    case GSharp6 = 'G#6';
    case A6 = 'A6';
    case ASharp6 = 'A#6';
    case B6 = 'B6';
    case C7 = 'C7';

    public static function options(): array
    {
        return [
            self::C3,
            self::CSharp3,
            self::D3,
            self::DSharp3,
            self::E3,
            self::F3,
            self::FSharp3,
            self::G3,
            self::GSharp3,
            self::A3,
            self::ASharp3,
            self::B3,
            self::C4,
            self::CSharp4,
            self::D4,
            self::DSharp4,
            self::E4,
            self::F4,
            self::FSharp4,
            self::G4,
            self::GSharp4,
            self::A4,
            self::ASharp4,
            self::B4,
            self::C5,
            self::CSharp5,
            self::D5,
            self::DSharp5,
            self::E5,
            self::F5,
            self::FSharp5,
            self::G5,
            self::GSharp5,
            self::A5,
            self::ASharp5,
            self::B5,
            self::C6,
            self::CSharp6,
            self::D6,
            self::DSharp6,
            self::E6,
            self::F6,
            self::FSharp6,
            self::G6,
            self::GSharp6,
            self::A6,
            self::ASharp6,
            self::B6,
            self::C7,
        ];
    }

    public static function choosableOptions(): array
    {
        return [
            self::C3,
            self::CSharp3,
            self::D3,
            self::DSharp3,
            self::E3,
            self::F3,
            self::FSharp3,
            self::G3,
            self::GSharp3,
            self::A3,
            self::ASharp3,
            self::B3,
            self::C4,
            self::CSharp4,
            self::D4,
            self::DSharp4,
            self::E4,
            self::F4,
            self::FSharp4,
            self::G4,
            self::GSharp4,
            self::A4,
            self::ASharp4,
            self::B4,
            self::C5,
        ];
    }

    public function trans(TranslatorInterface $translator): string
    {
        return $translator->trans('ui.note.' . $this->value);
    }

}