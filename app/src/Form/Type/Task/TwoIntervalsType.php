<?php

namespace App\Form\Type\Task;

use App\Entity\Enum\NoteEnum;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;

class TwoIntervalsType extends AbstractTaskType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        $builder
            ->add(
                'firstNote',
                EnumType::class,
                [
                    'label' => 'ui.task.firstNote',
                    'required' => true,
                    'class' => NoteEnum::class,
                    'choice_label' => fn(NoteEnum $note) => $note->trans($this->translator),
                ]
            )
            ->add(
                'secondNote',
                EnumType::class,
                [
                    'label' => 'ui.task.secondNote',
                    'required' => true,
                    'class' => NoteEnum::class,
                    'choice_label' => fn(NoteEnum $note) => $note->trans($this->translator),
                ]
            )
            ->add(
                'isFirstHarmonic',
                CheckboxType::class,
                [
                    'label' => 'ui.task.isFirstHarmonic',
                    'required' => false,
                ]
            )
            ->add(
                'thirdNote',
                EnumType::class,
                [
                    'label' => 'ui.task.thirdNote',
                    'required' => true,
                    'class' => NoteEnum::class,
                    'choice_label' => fn(NoteEnum $note) => $note->trans($this->translator),
                ]
            )
            ->add(
                'fourthNote',
                EnumType::class,
                [
                    'label' => 'ui.task.fourthNote',
                    'required' => true,
                    'class' => NoteEnum::class,
                    'choice_label' => fn(NoteEnum $note) => $note->trans($this->translator),
                ]
            )
            ->add(
                'isSecondHarmonic',
                CheckboxType::class,
                [
                    'label' => 'ui.task.isSecondHarmonic',
                    'required' => false,
                ]
            )
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'task';
    }
}
