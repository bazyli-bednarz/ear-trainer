<?php

namespace App\Controller;

use App\Entity\Enum\TaskTypeEnum;
use App\Entity\User;
use App\Service\Award\AwardServiceInterface;
use App\Service\Course\CourseServiceInterface;
use App\Service\Statistic\ExperienceStatisticServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractBaseController extends AbstractController
{
    public function __construct(
        protected readonly CourseServiceInterface $courseService,
        protected readonly TranslatorInterface    $translator,
        protected readonly ExperienceStatisticServiceInterface $experienceStatisticService,
        protected readonly AwardServiceInterface $awardService,
    )
    {
    }

    protected function render(string $view, array $parameters = [], ?Response $response = null): Response
    {
        $courses = $this->courseService->getMenuList();
        /** @var User $user */
        $user = $this->getUser();
        $userData = [];

        if ($user !== null) {
            $experience = $this->experienceStatisticService->getExperienceByUser($user);
            $userData['totalExperience'] = $experience;
            $userData['level'] = $this->experienceStatisticService->getLevelByExperience($experience);
            $userData['currentExperience'] = $this->experienceStatisticService->getExperienceOnCurrentLevel($experience);
            $userData['experienceToLevelUp'] = $this->experienceStatisticService->getExperienceToLevelUp($userData['level']);

            $userData['awards'] = $this->awardService->getLastAwardsForUser($user);
        }

        $taskTypes = [];
        foreach (TaskTypeEnum::cases() as $case) {
            $taskTypes[] = [
                'type' => $case->value,
                'label' => $case->trans($this->translator),
            ];
        }

        return parent::render($view, [...$parameters, 'courses' => $courses, 'taskTypes' => $taskTypes, 'userData' => $userData], $response);
    }
}
