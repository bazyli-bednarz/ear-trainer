<?php

namespace App\Form\Type\Node;

use App\Dto\Node\EditNodeDto;
use App\Entity\Course;
use App\Entity\Node;
use App\Service\Node\NodeServiceInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditNodeType extends AbstractType
{
    public function __construct(
        private readonly NodeServiceInterface $nodeService,
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
            'name',
            TextType::class,
            [
                'label' => 'ui.node.name',
                'required' => true,
                'attr' => ['max_length' => 255],
            ])
            ->add(
                'description',
                TextareaType::class,
                [
                    'label' => 'ui.node.description',
                    'required' => false,
                ])
            ->add(
                'icon',
                TextType::class,
                [
                    'label' => 'ui.node.icon',
                    'required' => true,
                    'attr' => ['max_length' => 255],
                ])
            ->add(
                'course',
                EntityType::class,
                [
                    'class' => Course::class,
                    'label' => 'ui.node.course',
                    'attr' => [
                        'disabled' => true,
                        'class' => 'disabled',
                    ],
                    'required' => true,
                    'choice_label' => 'name',
                    'data' => $options['course'],
                ])
            ->add(
                'previousNode',
                EntityType::class,
                [
                    'class' => Node::class,
                    'label' => 'ui.node.previousNode',
                    'required' => false,
                    'placeholder' => 'ui.node.firstNode',
                    'attr' => [
                        'class' => 'disabled',
                    ],
                    'choices' => $this->nodeService->getNodesForCourseExceptGiven($options['course'], $options['node']),
                    'choice_label' => 'name',
                    'data' => $options['previousNode'],
                ])
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'ui.action.save'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => EditNodeDto::class,
                'label' => 'ui.node.%name%',
                'previousNode' => null,
                'node' => null,
                'course' => null,
                'method' => 'PUT',
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'node';
    }
}
