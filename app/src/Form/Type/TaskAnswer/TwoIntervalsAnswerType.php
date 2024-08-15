<?php

namespace App\Form\Type\TaskAnswer;

use App\Entity\Enum\IntervalEnum;
use App\Entity\Enum\RelativePitchSoundAnswerEnum;
use App\Entity\Enum\TwoIntervalsTypeEnum;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class TwoIntervalsAnswerType extends AbstractTaskAnswerType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $firstIntervalChoices = IntervalEnum::options();
        if ($options['firstInterval']) {
            if (in_array($options['firstInterval'], IntervalEnum::simpleIntervalsOptions())) {
                $firstIntervalChoices = IntervalEnum::simpleIntervalsOptions();
            } else {
                $firstIntervalChoices = IntervalEnum::options();
            }
        }

        $secondIntervalChoices = IntervalEnum::options();
        if ($options['secondInterval']) {
            if (in_array($options['secondInterval'], IntervalEnum::simpleIntervalsOptions())) {
                $secondIntervalChoices = IntervalEnum::simpleIntervalsOptions();
            } else {
                $secondIntervalChoices = IntervalEnum::options();
            }
        }
        parent::buildForm($builder, $options);
        $builder
            ->add(
                'firstIntervalAnswer',
                ChoiceType::class,
                [
                    'label' => 'ui.task.firstIntervalAnswer',
                    'required' => true,
                    'choices' => $firstIntervalChoices,
                    'choice_label' => fn (IntervalEnum $choice) => $choice->trans($this->translator),
                    'attr' => ['class' => 'bg-dark text-white'],
                ]
            )
            ->add(
                'secondIntervalAnswer',
                ChoiceType::class,
                [
                    'label' => 'ui.task.secondIntervalAnswer',
                    'required' => true,
                    'choices' => $secondIntervalChoices,
                    'choice_label' => fn (IntervalEnum $choice) => $choice->trans($this->translator),
                    'attr' => ['class' => 'bg-dark text-white'],
                ]
            )
        ;

        if ($options['twoIntervalsType'] === TwoIntervalsTypeEnum::IntervalSquare) {
            $builder
                ->add(
                    'upperEdgeIntervalAnswer',
                    ChoiceType::class,
                    [
                        'label' => 'ui.task.upperEdgeIntervalAnswer',
                        'required' => true,
                        'choices' => IntervalEnum::options(),
                        'choice_label' => fn (IntervalEnum $choice) => $choice->trans($this->translator),
                        'attr' => ['class' => 'bg-dark text-white'],
                        ]
                )
                ->add(
                'lowerEdgeIntervalAnswer',
                ChoiceType::class,
                [
                    'label' => 'ui.task.lowerEdgeIntervalAnswer',
                    'required' => true,
                    'choices' => IntervalEnum::options(),
                    'choice_label' => fn (IntervalEnum $choice) => $choice->trans($this->translator),
                    'attr' => ['class' => 'bg-dark text-white'],
                ]
            );
        }
    }

    public function getBlockPrefix(): string
    {
        return 'answer';
    }
}
