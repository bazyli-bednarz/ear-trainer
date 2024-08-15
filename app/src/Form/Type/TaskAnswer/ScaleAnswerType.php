<?php

namespace App\Form\Type\TaskAnswer;

use App\Entity\Enum\FourNoteChordTypeEnum;
use App\Entity\Enum\ScaleTypeEnum;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class ScaleAnswerType extends AbstractTaskAnswerType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        parent::buildForm($builder, $options);
        $builder
            ->add(
                'scaleAnswer',
                ChoiceType::class,
                [
                    'label' => 'ui.task.scaleAnswer',
                    'required' => true,
                    'choices' => ScaleTypeEnum::options(),
                    'expanded' => true,
                    'choice_label' => fn(ScaleTypeEnum $choice) => $choice->trans($this->translator),
                ]
            );
    }

    public function getBlockPrefix(): string
    {
        return 'answer';
    }
}
