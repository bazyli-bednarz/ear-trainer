<?php

namespace App\Form\Type\Task;

use App\Entity\Enum\FourNoteChordTypeEnum;
use App\Entity\Enum\NoteEnum;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;

class FourNoteChordType extends AbstractTaskType
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
                'fourNoteChord',
                EnumType::class,
                [
                    'label' => 'ui.task.chord',
                    'required' => true,
                    'class' => FourNoteChordTypeEnum::class,
                    'choice_label' => fn(FourNoteChordTypeEnum $chord) => $chord->trans($this->translator),
            ])
            ->add(
                'isHarmonic',
                CheckboxType::class,
                [
                    'label' => 'ui.task.isHarmonic',
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
