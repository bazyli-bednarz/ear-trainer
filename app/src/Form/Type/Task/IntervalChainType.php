<?php

namespace App\Form\Type\Task;

use App\Entity\Enum\IntervalEnum;
use App\Entity\Enum\NoteEnum;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;

class IntervalChainType extends AbstractTaskType
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
                'intervalType',
                EnumType::class,
                [
                    'label' => 'ui.task.intervalType',
                    'required' => true,
                    'class' => IntervalEnum::class,
                    'choice_label' => fn(IntervalEnum $interval) => $interval->trans($this->translator),
                ]
            )
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
