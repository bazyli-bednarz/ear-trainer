<?php

namespace App\Form\Type\Security;

use App\Dto\User\UpdateUserDataDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateUserDataType extends AbstractType
{
    /**
     * Build form.
     *
     * @param FormBuilderInterface $builder Builder
     * @param array                $options Options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'ui.user.username',
                'required' => true,
                'attr' => ['max_length' => 150],
            ])
            ->add('oldPassword', PasswordType::class, [
                'required' => false,
                'label' => 'ui.user.oldPassword',
                'attr' => [
                    'placeholder' => 'ui.user.leaveBlank',
                ],

            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => false,
                'label' => 'ui.user.newPassword',


                'first_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'min-length' => 6,
                        'max_length' => 4096,
                        'placeholder' => 'ui.user.leaveBlank',
                    ],
                    'label' => 'ui.user.newPassword',
                ],
                'second_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'ui.user.leaveBlank',
                    ],
                    'label' => 'ui.user.passwordRepeat',
                ],
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

    /**
     * Configure options.
     *
     * @param OptionsResolver $resolver Resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateUserDataDto::class,
        ]);
    }
}
