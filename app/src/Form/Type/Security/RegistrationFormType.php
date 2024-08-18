<?php

namespace App\Form\Type\Security;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'ui.user.email',
                    'required' => true,
                    'attr' => ['max_length' => 150],
                ]
            )
            ->add(
                'username',
                TextType::class,
                [
                    'label' => 'ui.user.username',
                    'required' => true,
                    'attr' => ['max_length' => 255],
                ]
            )
            ->add(
                'agreeTerms',
                CheckboxType::class,
                [
                    'mapped' => false,
                    'required' => true,
                    'constraints' => [new IsTrue()],
                    'label' => 'ui.user.agreeToTerms',
                ]
            )
            ->add(
                'password',
                PasswordType::class,
                [
                    'mapped' => true,
                    'required' => true,
                    'label' => 'ui.user.password',
                    'attr' => ['autocomplete' => 'new-password', 'min-length' => 6, 'max_length' => 4096],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints' => [
                new UniqueEntity(
                    [
                        'entityClass' => User::class,
                        'fields' => 'email',
                    ]
                ),
            ],
        ]);
    }
}
