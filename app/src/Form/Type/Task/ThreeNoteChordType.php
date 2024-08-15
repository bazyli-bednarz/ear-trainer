<?php

namespace App\Form\Type\Task;

use App\Entity\Enum\IntervalEnum;
use App\Entity\Enum\InversionTypeEnum;
use App\Entity\Enum\NoteEnum;
use App\Entity\Enum\ThreeNoteChordTypeEnum;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;

class ThreeNoteChordType extends AbstractTaskType
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
                    'choices' => NoteEnum::choosableOptions(),
                    'choice_label' => fn(NoteEnum $note) => $note->trans($this->translator),
                ]
            )
            ->add(
                'chord',
                EnumType::class,
                [
                    'label' => 'ui.task.chord',
                    'required' => true,
                    'class' => ThreeNoteChordTypeEnum::class,
                    'choice_label' => fn(ThreeNoteChordTypeEnum $chord) => $chord->trans($this->translator),
            ])
            ->add(
                'inversion',
                EnumType::class,
                [
                    'label' => 'ui.task.inversion',
                    'required' => true,
                    'class' => InversionTypeEnum::class,
                    'choices' => InversionTypeEnum::threeNoteChordOptions(),
                    'choice_label' => fn(InversionTypeEnum $inversion) => $inversion->trans($this->translator),
                ])
            ->add(
                'isHarmonic',
                CheckboxType::class,
                [
                    'label' => 'ui.task.isHarmonic',
                    'required' => false,
                ]
            )
            ->add(
                'shouldStudentRecogniseInversion',
                CheckboxType::class,
                [
                    'label' => 'ui.task.shouldStudentRecogniseInversion',
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
