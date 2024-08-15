<?php

namespace App\Form\Type\TaskAnswer;

use App\Entity\Enum\FourNoteChordTypeEnum;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class FourNoteChordAnswerType extends AbstractTaskAnswerType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        parent::buildForm($builder, $options);
        $builder
            ->add(
                'fourNoteChordAnswer',
                ChoiceType::class,
                [
                    'label' => 'ui.task.chordAnswer',
                    'required' => true,
                    'choices' => FourNoteChordTypeEnum::options(),
                    'expanded' => true,
                    'choice_label' => fn(FourNoteChordTypeEnum $choice) => $choice->trans($this->translator),
                ]
            );
    }

    public function getBlockPrefix(): string
    {
        return 'answer';
    }
}
