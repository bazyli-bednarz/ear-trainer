<?php

namespace App\Controller;

use App\Dto\Course\CreateCourseDto;
use App\Dto\Course\EditCourseDto;
use App\Dto\Node\CreateNodeDto;
use App\Dto\Node\EditNodeDto;
use App\Entity\Course;
use App\Entity\Node;
use App\Form\Type\Course\CreateCourseType;
use App\Form\Type\Course\EditCourseType;
use App\Form\Type\Node\CreateNodeType;
use App\Form\Type\Node\EditNodeType;
use App\Service\Course\CourseServiceInterface;
use App\Service\Node\NodeServiceInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/kursy')]
class CourseController extends AbstractBaseController
{
    public function __construct(
        CourseServiceInterface $courseService,
        private readonly TranslatorInterface $translator,
        private readonly NodeServiceInterface $nodeService,
    )
    {
        parent::__construct($courseService);
    }

    #[Route('/', name: 'course_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        return $this->render('course/index.html.twig');
    }

    #[Route(
        '/{slug}/dodaj-lekcje',
        name: 'node_create',
        methods: ['GET', 'POST']
    )]
    public function createNode(Course $course, Request $request): Response
    {
        try {
            $prevNodeId = intval($request->get('prevNodeId'));
        } catch (\Exception $e) {
            $prevNodeId = null;
        }

        $prevNode = $prevNodeId ? $this->nodeService->getById($prevNodeId) : null;

        $form = $this->createForm(CreateNodeType::class, $dto = new CreateNodeDto(), ['course' => $course, 'previousNode' => $prevNode]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dto = $form->getData();
            $node = $this->nodeService->create($dto, $course);

            $this->addFlash(
                'success',
                $this->translator->trans('ui.message.created.node', ['%name%' => $node->getName()])
            );

            return $this->redirectToRoute('course_show', ['slug' => $course->getSlug()]);
        }

        return $this->render(
            'node/create.html.twig',
            [
                'back_to_list_path' => 'course_index',
                'form' => $form->createView(),
                'course' => $course
            ]
        );
    }

    #[Route(
        '/{slug}/{nodeSlug}/edytuj',
        name: 'node_update',
        methods: ['GET', 'PUT']
    )]
    public function editNode(
        #[MapEntity(mapping: ['slug' => 'slug'])] Course $course,
        #[MapEntity(mapping: ['nodeSlug' => 'slug'])] Node $node,
        Request $request
    ): Response
    {

        $prevNode = $node->getPreviousNode();
        $form = $this->createForm(
            EditNodeType::class,
            $dto = EditNodeDto::fromEntity($node),
            [
                'course' => $course,
                'previousNode' => $prevNode,
                'node' => $node]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dto = $form->getData();
            $node = $this->nodeService->update($node, $dto);

            $this->addFlash(
                'success',
                $this->translator->trans('ui.message.updated.node', ['%name%' => $node->getName()])
            );


            return $this->redirectToRoute('node_show', ['slug' => $course->getSlug(), 'nodeSlug' => $node->getSlug()]);
        }


        return $this->render(
            'node/edit.html.twig',
            [
                'node' => $node,
                'form' => $form->createView(),
                'back_to_list_path' => 'course_index',
            ]
        );
    }

    #[Route(
        '/{slug}/{nodeSlug}/usun',
        name: 'node_delete',
        methods: ['GET', 'DELETE']
    )]
    public function deleteNode(
        #[MapEntity(mapping: ['slug' => 'slug'])] Course $course,
        #[MapEntity(mapping: ['nodeSlug' => 'slug'])] Node $node,
        Request $request
    ): Response
    {
        $form = $this->createForm(FormType::class, $node, [
            'method' => 'DELETE',
            'action' => $this->generateUrl('node_delete', [
                'slug' => $course->getSlug(),
                'nodeSlug' => $node->getSlug()
            ]),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $deletedNodeName = $node->getName();
            $this->nodeService->delete($node);

            $this->addFlash(
                'success',
                $this->translator->trans('ui.message.deleted.node', ['%name%' => $deletedNodeName])
            );

            return $this->redirectToRoute('course_show', ['slug' => $course->getSlug()]);

        }

        return $this->render(
            'node/delete.html.twig',
            [
                'form' => $form->createView(),
                'node' => $node
            ]
        );
    }



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

    #[Route(
        '/{slug}/{nodeSlug}',
        name: 'node_show',
        methods: ['GET'])
    ]
    public function showNode(
        #[MapEntity(mapping: ['slug' => 'slug'])] Course $course,
        #[MapEntity(mapping: ['nodeSlug' => 'slug'])] Node $node,
        Request $request
    ): Response
    {

        return $this->render(
            'node/show.html.twig',
            [
                'course' => $course,
                'node' => $node,
            ]
        );
    }

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
        $nodes = $this->nodeService->getNodesForCourse($course);

        return $this->render(
            'course/show.html.twig',
            [
                'course' => $course,
                'nodes' => $nodes,
            ]
        );
    }
}
