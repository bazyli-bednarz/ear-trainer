<?php

namespace App\Controller;

use App\Service\Award\AwardServiceInterface;
use App\Service\Course\CourseServiceInterface;
use App\Service\Statistic\ExperienceStatisticServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/ranking')]
class RankingController extends AbstractBaseController
{

    public function __construct(
        CourseServiceInterface $courseService,
        TranslatorInterface $translator,
        ExperienceStatisticServiceInterface $experienceStatisticService,
        AwardServiceInterface $awardService
    )
    {
        parent::__construct($courseService, $translator, $experienceStatisticService, $awardService);
    }

    #[Route(name: 'ranking_index', methods: ['GET'])]
    public function topExperience(Request $request): Response
    {
        $users = $this->experienceStatisticService->getTopExperienceUsers(10);
        return $this->render('ranking/index.html.twig', [
            'users' => $users
        ]);
    }
}
