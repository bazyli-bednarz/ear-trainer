<?php

namespace App\Form\Type\TaskAnswer;

use App\Entity\Enum\IntervalEnum;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class IntervalChainAnswerType extends AbstractTaskAnswerType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        parent::buildForm($builder, $options);
        $builder
            ->add(
                'intervalAnswer',
                ChoiceType::class,
                [
                    'label' => false,
                    'required' => true,
                    'choices' => IntervalEnum::optionsForIntervalChain(),
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
