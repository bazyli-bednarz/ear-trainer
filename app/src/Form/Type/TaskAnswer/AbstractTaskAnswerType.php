<?php

namespace App\Form\Type\TaskAnswer;

use App\Dto\Node\CreateNodeDto;
use App\Dto\Task\TaskDto;
use App\Dto\TaskAnswer\TaskAnswerDto;
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

class AbstractTaskAnswerType extends AbstractType
{
    public function __construct(
        protected readonly TaskServiceInterface $taskService,
        protected readonly TranslatorInterface  $translator,
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add(
                'check',
                SubmitType::class,
                [
                    'label' => 'ui.action.check',
                    'priority' => -1,
                ]
            );

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => TaskAnswerDto::class,
                'label' => 'ui.task.%name%',
                'nextTask' => null,
                'course' => null,
                'node' => null,
                'type' => null,
                'task' => null,
                'interval' => false,
                'firstInterval' => false,
                'secondInterval' => false,
                'twoIntervalsType' => null,
                'shouldStudentRecogniseInversion' => false,
                'chord' => null,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'task';
    }
}
