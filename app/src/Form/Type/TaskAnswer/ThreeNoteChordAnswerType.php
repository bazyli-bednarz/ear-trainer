<?php

namespace App\Form\Type\TaskAnswer;

use App\Entity\Enum\IntervalEnum;
use App\Entity\Enum\InversionTypeEnum;
use App\Entity\Enum\ThreeNoteChordTypeEnum;
use App\Entity\Enum\TwoIntervalsTypeEnum;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class ThreeNoteChordAnswerType extends AbstractTaskAnswerType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        parent::buildForm($builder, $options);
        $builder
            ->add(
                'threeNoteChordAnswer',
                ChoiceType::class,
                [
                    'label' => 'ui.task.chordAnswer',
                    'required' => true,
                    'choices' => ThreeNoteChordTypeEnum::options(),
                    'expanded' => true,
                    'choice_label' => fn(ThreeNoteChordTypeEnum $choice) => $choice->trans($this->translator),
                ]
            );

        if (
            true === $options['shouldStudentRecogniseInversion']
            && $options['chord'] !== ThreeNoteChordTypeEnum::Augmented
        ) {
            $builder
                ->add(
                    'inversionAnswer',
                    ChoiceType::class,
                    [
                        'label' => 'ui.task.inversionAnswer',
                        'required' => true,
                        'choices' => InversionTypeEnum::threeNoteChordOptions(),
                        'expanded' => true,
                        'choice_label' => fn(InversionTypeEnum $choice) => $choice->trans($this->translator),
                    ]);
        }
    }

    public function getBlockPrefix(): string
    {
        return 'answer';
    }
}
