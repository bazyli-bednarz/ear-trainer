<?php

namespace App\Form\Type\Task;

use App\Entity\Enum\NoteEnum;
use App\Entity\Enum\ScaleTypeEnum;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;

class ScaleType extends AbstractTaskType
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
                'scaleType',
                EnumType::class,
                [
                    'label' => 'ui.task.scale',
                    'required' => true,
                    'class' => ScaleTypeEnum::class,
                    'choice_label' => fn(ScaleTypeEnum $scale) => $scale->trans($this->translator),
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'task';
    }
}
