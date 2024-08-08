<?php

namespace App\Form\Type\Course;

use App\Dto\Course\EditCourseDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditCourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
            'name',
            TextType::class,
            [
                'label' => 'ui.course.name',
                'required' => true,
                'attr' => ['max_length' => 255],
            ])
            ->add(
                'description',
                TextareaType::class,
                [
                    'label' => 'ui.course.description',
                    'required' => false,
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
                'data_class' => EditCourseDto::class,
                'label' => 'ui.course.%name%',
                'method' => 'PUT',
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'course';
    }
}
