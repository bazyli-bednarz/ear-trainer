<?php

namespace App\Controller;

use App\Dto\Task\CreateTaskDto;
use App\Entity\Course;
use App\Entity\Enum\TaskTypeEnum;
use App\Entity\Node;
use App\Entity\Task\AbstractTask;
use App\Form\Type\Task\CreateIntervalType;
use App\Form\Type\Task\CreateRelativePitchSoundType;
use App\Service\Course\CourseServiceInterface;
use App\Service\Node\NodeServiceInterface;
use App\Service\Task\TaskServiceInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/kursy')]
class TaskController extends AbstractBaseController
{
    public function __construct(
        CourseServiceInterface                $courseService,
        TranslatorInterface                   $translator,
        private readonly NodeServiceInterface $nodeService,
        private readonly TaskServiceInterface $taskService,
    )
    {
        parent::__construct($courseService, $translator);
    }


    #[Route(
        '/{slug}/{nodeSlug}/dodaj-zadanie/{type}',
        name: 'task_create',
        methods: ['GET', 'POST']
    )]
    public function create(
        #[MapEntity(mapping: ['slug' => 'slug'])] Course   $course,
        #[MapEntity(mapping: ['nodeSlug' => 'slug'])] Node $node,
        string                                             $type,
        Request                                            $request
    ): Response
    {
        $type = TaskTypeEnum::tryFrom($type);
        try {
            $prevTaskId = intval($request->get('prevTaskId'));
        } catch (\Exception $e) {
            $prevTaskId = null;
        }

        $prevTask = $prevTaskId ? $this->nodeService->getById($prevTaskId) : null;

        $formType = match ($type) {
            TaskTypeEnum::RelativePitchSound => CreateRelativePitchSoundType::class,
            TaskTypeEnum::Interval => CreateIntervalType::class,
            default => throw new \InvalidArgumentException('Invalid task type')
        };

        $form = $this->createForm(
            $formType,
            $dto = new CreateTaskDto($type),
            [
                'course' => $course,
                'node' => $node,
                'previousTask' => $prevTask,
                'type' => $type,
            ]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $this->taskService->create($dto, $node);

            $this->addFlash(
                'success',
                $this->translator->trans('ui.message.created.task', ['%name%' => $task->getName()])
            );

            return $this->redirectToRoute('node_show', ['slug' => $course->getSlug(), 'nodeSlug' => $node->getSlug()]);
        }

        return $this->render(
            'task/create.html.twig',
            [
                'back_to_list_path' => 'course_index',
                'form' => $form->createView(),
                'course' => $course,
                'node' => $node,
                'type' => $type,
            ]
        );
    }
//
//    #[Route(
//        '/{slug}/{nodeSlug}/edytuj',
//        name: 'node_update',
//        methods: ['GET', 'PUT']
//    )]
//    public function editNode(
//        #[MapEntity(mapping: ['slug' => 'slug'])] Course $course,
//        #[MapEntity(mapping: ['nodeSlug' => 'slug'])] Node $node,
//        Request $request
//    ): Response
//    {
//
//        $prevNode = $node->getPreviousNode();
//        $form = $this->createForm(
//            EditNodeType::class,
//            $dto = EditNodeDto::fromEntity($node),
//            [
//                'course' => $course,
//                'previousNode' => $prevNode,
//                'node' => $node]
//        );
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $dto = $form->getData();
//            $node = $this->nodeService->update($node, $dto);
//
//            $this->addFlash(
//                'success',
//                $this->translator->trans('ui.message.updated.node', ['%name%' => $node->getName()])
//            );
//
//
//            return $this->redirectToRoute('node_show', ['slug' => $course->getSlug(), 'nodeSlug' => $node->getSlug()]);
//        }
//
//
//        return $this->render(
//            'node/edit.html.twig',
//            [
//                'node' => $node,
//                'form' => $form->createView(),
//                'back_to_list_path' => 'course_index',
//            ]
//        );
//    }
//
//    #[Route(
//        '/{slug}/{nodeSlug}/usun',
//        name: 'node_delete',
//        methods: ['GET', 'DELETE']
//    )]
//    public function deleteNode(
//        #[MapEntity(mapping: ['slug' => 'slug'])] Course $course,
//        #[MapEntity(mapping: ['nodeSlug' => 'slug'])] Node $node,
//        Request $request
//    ): Response
//    {
//        $form = $this->createForm(FormType::class, $node, [
//            'method' => 'DELETE',
//            'action' => $this->generateUrl('node_delete', [
//                'slug' => $course->getSlug(),
//                'nodeSlug' => $node->getSlug()
//            ]),
//        ]);
//
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $deletedNodeName = $node->getName();
//            $this->nodeService->delete($node);
//
//            $this->addFlash(
//                'success',
//                $this->translator->trans('ui.message.deleted.node', ['%name%' => $deletedNodeName])
//            );
//
//            return $this->redirectToRoute('course_show', ['slug' => $course->getSlug()]);
//
//        }
//
//        return $this->render(
//            'node/delete.html.twig',
//            [
//                'form' => $form->createView(),
//                'node' => $node
//            ]
//        );
//    }


    #[Route(
        '/{slug}/{nodeSlug}/{taskSlug}',
        name: 'task_show',
        methods: ['GET'])
    ]
    public function show(
        #[MapEntity(mapping: ['slug' => 'slug'])] Course           $course,
        #[MapEntity(mapping: ['nodeSlug' => 'slug'])] Node         $node,
        #[MapEntity(mapping: ['taskSlug' => 'slug'])] AbstractTask $task,
        Request                                                    $request
    ): Response
    {

        return $this->render(
            'task/show.html.twig',
            [
                'course' => $course,
                'node' => $node,
                'task' => $task,
            ]
        );
    }

}
