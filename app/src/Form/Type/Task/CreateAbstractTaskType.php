<?php

namespace App\Form\Type\Task;

use App\Dto\Node\CreateNodeDto;
use App\Dto\Task\CreateTaskDto;
use App\Entity\Course;
use App\Entity\Enum\NoteEnum;
use App\Entity\Enum\TaskTypeEnum;
use App\Entity\Node;
use App\Entity\Task\AbstractTask;
use App\Service\Task\TaskServiceInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class CreateAbstractTaskType extends AbstractType
{
    public function __construct(
        protected readonly TaskServiceInterface $taskService,
        protected readonly TranslatorInterface $translator,
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'course',
                EntityType::class,
                [
                    'class' => Course::class,
                    'label' => 'ui.task.course',
                    'attr' => [
                        'disabled' => true,
                        'class' => 'disabled',
                    ],
                    'required' => true,
                    'choice_label' => 'name',
                    'data' => $options['course'],
                ])
            ->add(
                'node',
                EntityType::class,
                [
                    'class' => Node::class,
                    'label' => 'ui.task.node',
                    'attr' => [
                        'disabled' => true,
                        'class' => 'disabled',
                    ],
                    'required' => true,
                    'choice_label' => 'name',
                    'data' => $options['node'],
                ])
            ->add(
                'type',
                EnumType::class,
                [
                    'label' => 'ui.task.type',
                    'class' => TaskTypeEnum::class,
                    'attr' => [
                        'disabled' => true,
                        'class' => 'disabled',
                    ],
                    'required' => true,
                    'choice_label' => fn(TaskTypeEnum $type) => $type->trans($this->translator),
                    'data' => $options['type'],
                    'empty_data' => $options['type']->value,
                ]
            )
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'ui.task.name',
                    'required' => true,
                    'attr' => ['max_length' => 255],
                ])
            ->add(
                'description',
                TextareaType::class,
                [
                    'label' => 'ui.task.description',
                    'required' => false,
                ])

            ->add(
                'previousTask',
                EntityType::class,
                [
                    'class' => AbstractTask::class,
                    'label' => 'ui.task.previousTask',
                    'required' => false,
                    'placeholder' => 'ui.task.firstTask',
                    'choices' => $this->taskService->getTasksForNode($options['node']),
                    'choice_label' => 'name',
                    'data' => $options['previousTask'],
                ])
            ->add(
                'points',
                IntegerType::class,
                [
                    'label' => 'ui.task.points',
                    'required' => true,
                    'attr' => ['min' => 0],
                ])
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'ui.action.save',
                    'priority' => -1,
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => CreateTaskDto::class,
                'label' => 'ui.task.%name%',
                'previousTask' => null,
                'course' => null,
                'node' => null,
                'type' => null,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'task';
    }
}
