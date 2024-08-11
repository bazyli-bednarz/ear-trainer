<?php

namespace App\Entity\Enum;

use Symfony\Contracts\Translation\TranslatorInterface;

enum TaskTypeEnum: string
{
    case RelativePitchSound = 'RelativePitchSound';
    /**
     * Interval includes:
     *  - simple intervals
     *  - compound intervals
     *  - harmonic intervals
     *  - melodic intervals
     */
    case Interval = 'Interval';
    case TwoIntervals = 'TwoIntervals';
    case IntervalChain = 'IntervalChain';
    /**
     * Chord also includes inversions.
     */
    case ThreeNoteChord = 'ThreeNoteChord';
    case FourNoteChord = 'FourNoteChord';
    case Scale = 'Scale';

    public static function options(): array
    {
        return [
            self::RelativePitchSound,
            self::Interval,
            self::TwoIntervals,
            self::IntervalChain,
            self::ThreeNoteChord,
            self::FourNoteChord,
            self::Scale,
        ];
    }

    public static function translatedOptions(TranslatorInterface $translator): array
    {
        return array_map(fn(self $option) => $translator->trans('ui.taskType.' . $option->value), self::options());
    }

    public function trans(TranslatorInterface $translator): string
    {
        return $translator->trans('ui.taskType.' . $this->value);
    }
}