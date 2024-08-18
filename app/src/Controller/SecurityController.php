<?php

namespace App\Controller;

use App\Dto\User\UpdateUserDataDto;
use App\Entity\User;
use App\Form\Type\ChangePasswordType;
use App\Form\Type\Security\UpdateUserDataType;
use App\Service\Award\AwardServiceInterface;
use App\Service\Course\CourseServiceInterface;
use App\Service\Statistic\ExperienceStatisticServiceInterface;
use App\Service\User\UserServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

class SecurityController extends AbstractBaseController
{
    public function __construct(
        CourseServiceInterface $courseService,
        TranslatorInterface $translator,
        ExperienceStatisticServiceInterface $experienceStatisticService,
        AwardServiceInterface $awardService,
        private readonly UserServiceInterface $userService
    )
    {
        parent::__construct($courseService, $translator, $experienceStatisticService, $awardService);
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/wyloguj', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/zmien-dane', name: 'app_security_edit')]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function edit(Request $request, UserPasswordHasherInterface $userPasswordHasher, TranslatorInterface $translator): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(UpdateUserDataType::class, $dto = UpdateUserDataDto::fromEntity($user));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $username = $dto->getUsername();
            $oldPassword = $dto->getOldPassword();
            $newPassword = $dto->getNewPassword();

            if ($username !== $user->getUsername()) {
                $this->userService->updateUsername($user, $username);
                $this->addFlash(
                    'success',
                    $translator->trans('ui.message.security.nameUpdated')
                );
            }

            if ($newPassword && $oldPassword && !$userPasswordHasher->isPasswordValid($user, $oldPassword)) {
                $this->addFlash(
                    'danger',
                    $translator->trans('ui.message.security.oldPasswordWrong')
                );

                return $this->redirectToRoute('app_security_edit');
            }

            if ($newPassword && !$oldPassword) {
                $this->addFlash(
                    'danger',
                    $translator->trans('ui.message.security.oldPasswordWrong')
                );

                return $this->redirectToRoute('app_security_edit');
            }

            if (!$newPassword && $oldPassword) {
                $this->addFlash(
                    'danger',
                    $translator->trans('ui.message.security.newPasswordEmpty')
                );

                return $this->redirectToRoute('app_security_edit');
            }

            if ($newPassword && $oldPassword) {
                $encodedPassword = $userPasswordHasher->hashPassword(
                    $user,
                    $newPassword
                );

                $this->userService->upgradePassword($user, $encodedPassword);

                $this->addFlash(
                    'success',
                    $translator->trans('ui.message.security.updated')
                );
            }

            return $this->redirectToRoute('app_security_edit');
        }

        return $this->render(
            'security/edit.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
            ]
        );
    }

}
