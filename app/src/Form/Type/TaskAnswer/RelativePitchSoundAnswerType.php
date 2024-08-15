<?php

namespace App\Form\Type\TaskAnswer;

use App\Entity\Enum\RelativePitchSoundAnswerEnum;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class RelativePitchSoundAnswerType extends AbstractTaskAnswerType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        $builder
            ->add(
                'relativePitchSoundAnswer',
                ChoiceType::class,
                [
                    'label' => false,
                    'required' => true,
                    'choices' => RelativePitchSoundAnswerEnum::options(),
                    'expanded' => true,
                    'choice_label' => fn (RelativePitchSoundAnswerEnum $choice) => $choice->trans($this->translator),
                ]
            )
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'answer';
    }
}
