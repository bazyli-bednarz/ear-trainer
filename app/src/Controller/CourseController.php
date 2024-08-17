<?php

namespace App\Controller;

use App\Dto\Course\CreateCourseDto;
use App\Dto\Course\EditCourseDto;
use App\Entity\Course;
use App\Entity\User;
use App\Form\Type\Course\CreateCourseType;
use App\Form\Type\Course\EditCourseType;
use App\Service\Award\AwardServiceInterface;
use App\Service\Course\CourseServiceInterface;
use App\Service\Node\NodeServiceInterface;
use App\Service\Statistic\ExperienceStatisticService;
use App\Service\Statistic\ExperienceStatisticServiceInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\SecurityBundle\Security;

#[Route('/kursy')]
class CourseController extends AbstractBaseController
{
    public function __construct(
        CourseServiceInterface                $courseService,
        TranslatorInterface                   $translator,
        ExperienceStatisticServiceInterface   $experienceStatisticService,
        AwardServiceInterface                 $awardService,
        private readonly NodeServiceInterface $nodeService,
        private readonly Security             $security,
    )
    {
        parent::__construct($courseService, $translator, $experienceStatisticService, $awardService);
    }

    #[Route('/', name: 'course_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        return $this->render('course/index.html.twig');
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route(
        '/{slug}/edytuj',
        name: 'course_update',
        methods: ['GET', 'PUT']
    )]
    public function edit(Course $course, Request $request): Response
    {
        $form = $this->createForm(EditCourseType::class, $dto = EditCourseDto::fromEntity($course));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dto = $form->getData();
            $course = $this->courseService->update($course, $dto);

            $this->addFlash(
                'success',
                $this->translator->trans('ui.message.updated.course', ['%name%' => $course->getName()])
            );


            return $this->redirectToRoute('course_show', ['slug' => $course->getSlug()]);
        }


        return $this->render(
            'course/edit.html.twig',
            [
                'course' => $course,
                'form' => $form->createView(),
                'back_to_list_path' => 'course_index',
            ]
        );
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route(
        '/{slug}/usun',
        name: 'course_delete',
        methods: ['GET', 'DELETE']
    )]
    public function delete(Course $course, Request $request): Response
    {
        $form = $this->createForm(FormType::class, $course, [
            'method' => 'DELETE',
            'action' => $this->generateUrl('course_delete', ['slug' => $course->getSlug()]),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $deletedCourseName = $course->getName();
            $this->courseService->delete($course);

            $this->addFlash(
                'success',
                $this->translator->trans('ui.message.deleted.course', ['%name%' => $deletedCourseName])
            );

            return $this->redirectToRoute('course_index');

        }

        return $this->render(
            'course/delete.html.twig',
            [
                'form' => $form->createView(),
                'course' => $course
            ]
        );
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route(
        '/nowy',
        name: 'course_create',
        methods: ['GET', 'POST']
    )]
    public function create(Request $request): Response
    {
        $form = $this->createForm(CreateCourseType::class, $dto = new CreateCourseDto());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dto = $form->getData();
            $course = $this->courseService->create($dto);

            $this->addFlash(
                'success',
                $this->translator->trans('ui.message.created.course', ['%name%' => $course->getName()])
            );

            return $this->redirectToRoute('course_show', ['slug' => $course->getSlug()]);
        }

        return $this->render(
            'course/create.html.twig',
            [
                'back_to_list_path' => 'course_index',
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(
        '/{slug}',
        name: 'course_show',
        methods: ['GET'])
    ]
    public function show(Course $course, Request $request): Response
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $nodes = $this->nodeService->getNodesForCourseWithUserInfo($course, $user);

        return $this->render(
            'course/show.html.twig',
            [
                'course' => $course,
                'nodes' => $nodes,
            ]
        );
    }
}
