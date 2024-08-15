<?php

namespace App\Form\Type\TaskAnswer;

use App\Entity\Enum\IntervalEnum;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class IntervalAnswerType extends AbstractTaskAnswerType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $intervalChoices = IntervalEnum::options();
        if ($options['interval']) {
            if (in_array($options['interval'], IntervalEnum::simpleIntervalsOptions())) {
                $intervalChoices = IntervalEnum::simpleIntervalsOptions();
            } else {
                $intervalChoices = IntervalEnum::options();
            }
        }
        parent::buildForm($builder, $options);
        $builder
            ->add(
                'intervalAnswer',
                ChoiceType::class,
                [
                    'label' => false,
                    'required' => true,
                    'choices' => $intervalChoices,
                    'expanded' => true,
                    'choice_label' => fn (IntervalEnum $choice) => $choice->trans($this->translator),
                ]
            )
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'answer';
    }
}
