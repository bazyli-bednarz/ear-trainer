<?php

namespace App\Controller;

use App\Dto\Task\TaskDto;
use App\Dto\TaskAnswer\TaskAnswerDto;
use App\Entity\Course;
use App\Entity\Enum\AwardEnum;
use App\Entity\Enum\TaskTypeEnum;
use App\Entity\Node;
use App\Entity\Task\AbstractTask;
use App\Entity\Task\Interval;
use App\Entity\User;
use App\Form\Type\Task\AbstractTaskType;
use App\Form\Type\Task\FourNoteChordType;
use App\Form\Type\Task\IntervalChainType;
use App\Form\Type\Task\IntervalType;
use App\Form\Type\Task\RelativePitchSoundType;
use App\Form\Type\Task\ScaleType;
use App\Form\Type\Task\ThreeNoteChordType;
use App\Form\Type\Task\TwoIntervalsType;
use App\Form\Type\TaskAnswer\FourNoteChordAnswerType;
use App\Form\Type\TaskAnswer\IntervalAnswerType;
use App\Form\Type\TaskAnswer\IntervalChainAnswerType;
use App\Form\Type\TaskAnswer\RelativePitchSoundAnswerType;
use App\Form\Type\TaskAnswer\ScaleAnswerType;
use App\Form\Type\TaskAnswer\ThreeNoteChordAnswerType;
use App\Form\Type\TaskAnswer\TwoIntervalsAnswerType;
use App\Service\Award\AwardServiceInterface;
use App\Service\Course\CourseServiceInterface;
use App\Service\Node\NodeServiceInterface;
use App\Service\Statistic\ExperienceStatisticServiceInterface;
use App\Service\Statistic\TaskStatisticServiceInterface;
use App\Service\Task\TaskServiceInterface;
use App\Service\TaskAnswer\TaskAnswerServiceInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/kursy')]
class TaskController extends AbstractBaseController
{
    public function __construct(
        CourseServiceInterface                         $courseService,
        TranslatorInterface                            $translator,
        ExperienceStatisticServiceInterface            $experienceStatisticService,
        AwardServiceInterface                          $awardService,
        private readonly NodeServiceInterface          $nodeService,
        private readonly TaskServiceInterface          $taskService,
        private readonly TaskAnswerServiceInterface    $taskAnswerService,
        private readonly TaskStatisticServiceInterface $taskStatisticService,
        private readonly Security                      $security,
    )
    {
        parent::__construct($courseService, $translator, $experienceStatisticService, $awardService);
    }


    #[IsGranted("ROLE_ADMIN")]
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
            TaskTypeEnum::RelativePitchSound => RelativePitchSoundType::class,
            TaskTypeEnum::Interval => IntervalType::class,
            TaskTypeEnum::TwoIntervals => TwoIntervalsType::class,
            TaskTypeEnum::IntervalChain => IntervalChainType::class,
            TaskTypeEnum::ThreeNoteChord => ThreeNoteChordType::class,
            TaskTypeEnum::FourNoteChord => FourNoteChordType::class,
            TaskTypeEnum::Scale => ScaleType::class,
            default => throw new \InvalidArgumentException('Invalid task type')
        };

        $form = $this->createForm(
            $formType,
            $dto = new TaskDto($type),
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

    #[IsGranted("ROLE_ADMIN")]
    #[Route(
        '/{slug}/{nodeSlug}/{taskSlug}/edytuj',
        name: 'task_update',
        methods: ['GET', 'PUT']
    )]
    public function edit(
        #[MapEntity(mapping: ['slug' => 'slug'])] Course           $course,
        #[MapEntity(mapping: ['nodeSlug' => 'slug'])] Node         $node,
        #[MapEntity(mapping: ['taskSlug' => 'slug'])] AbstractTask $task,
        Request                                                    $request
    ): Response
    {
        $prevTask = $task->getPreviousTask();

        $formType = match ($task->getType()) {
            TaskTypeEnum::RelativePitchSound => RelativePitchSoundType::class,
            TaskTypeEnum::Interval => IntervalType::class,
            TaskTypeEnum::TwoIntervals => TwoIntervalsType::class,
            TaskTypeEnum::IntervalChain => IntervalChainType::class,
            TaskTypeEnum::ThreeNoteChord => ThreeNoteChordType::class,
            TaskTypeEnum::FourNoteChord => FourNoteChordType::class,
            TaskTypeEnum::Scale => ScaleType::class,
            default => throw new \InvalidArgumentException('Invalid task type')
        };

        $form = $this->createForm(
            $formType,
            $dto = TaskDto::fromEntity($task),
            [
                'course' => $course,
                'previousTask' => $prevTask,
                'node' => $node,
                'isEdit' => true,
                'task' => $task,
                'type' => $task->getType(),
                'method' => 'PUT',
            ],
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $this->taskService->update($task, $dto);

            $this->addFlash(
                'success',
                $this->translator->trans('ui.message.updated.task', ['%name%' => $task->getName()])
            );


            return $this->redirectToRoute('task_show', ['slug' => $course->getSlug(), 'nodeSlug' => $node->getSlug(), 'taskSlug' => $task->getSlug()]);
        }


        return $this->render(
            'task/edit.html.twig',
            [
                'course' => $course,
                'node' => $node,
                'task' => $task,
                'form' => $form->createView(),
                'back_to_list_path' => 'course_index',
            ]
        );
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route(
        '/{slug}/{nodeSlug}/{taskSlug}/usun',
        name: 'task_delete',
        methods: ['GET', 'DELETE']
    )]
    public function deleteNode(
        #[MapEntity(mapping: ['slug' => 'slug'])] Course           $course,
        #[MapEntity(mapping: ['nodeSlug' => 'slug'])] Node         $node,
        #[MapEntity(mapping: ['taskSlug' => 'slug'])] AbstractTask $task,
        Request                                                    $request
    ): Response
    {
        $form = $this->createForm(FormType::class, $node, [
            'method' => 'DELETE',
            'action' => $this->generateUrl('task_delete', [
                'slug' => $course->getSlug(),
                'nodeSlug' => $node->getSlug(),
                'taskSlug' => $task->getSlug(),
            ]),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $deletedTaskName = $task->getName();
            $this->taskService->delete($task);

            $this->addFlash(
                'success',
                $this->translator->trans('ui.message.deleted.task', ['%name%' => $deletedTaskName])
            );

            return $this->redirectToRoute('node_show', ['slug' => $course->getSlug(), 'nodeSlug' => $node->getSlug()]);

        }

        return $this->render(
            'task/delete.html.twig',
            [
                'form' => $form->createView(),
                'node' => $node,
                'task' => $task,
            ]
        );
    }


    #[Route(
        '/{slug}/{nodeSlug}/{taskSlug}',
        name: 'task_show',
        methods: ['GET', 'POST'])
    ]
    public function show(
        #[MapEntity(mapping: ['slug' => 'slug'])] Course           $course,
        #[MapEntity(mapping: ['nodeSlug' => 'slug'])] Node         $node,
        #[MapEntity(mapping: ['taskSlug' => 'slug'])] AbstractTask $task,
        Request                                                    $request
    ): Response
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $nextTask = $task->getNextTask();

        $formType = match ($task->getType()) {
            TaskTypeEnum::RelativePitchSound => RelativePitchSoundAnswerType::class,
            TaskTypeEnum::Interval => IntervalAnswerType::class,
            TaskTypeEnum::TwoIntervals => TwoIntervalsAnswerType::class,
            TaskTypeEnum::IntervalChain => IntervalChainAnswerType::class,
            TaskTypeEnum::ThreeNoteChord => ThreeNoteChordAnswerType::class,
            TaskTypeEnum::FourNoteChord => FourNoteChordAnswerType::class,
            TaskTypeEnum::Scale => ScaleAnswerType::class,
            default => throw new \InvalidArgumentException('Invalid task type')
        };

        $form = $this->createForm(
            $formType,
            $dto = new TaskAnswerDto(),
            [
                'course' => $course,
                'nextTask' => $nextTask,
                'node' => $node,
                'task' => $task,
                'type' => $task->getType(),
                'interval' => $task->getType() === TaskTypeEnum::Interval ? $task->getIntervalType() : false,
                'firstInterval' => $task->getType() === TaskTypeEnum::TwoIntervals ? $task->getFirstIntervalType() : false,
                'secondInterval' => $task->getType() === TaskTypeEnum::TwoIntervals ? $task->getSecondIntervalType() : false,
                'twoIntervalsType' => $task->getType() === TaskTypeEnum::TwoIntervals ? $task->getTwoIntervalsTypeEnum() : null,
                'chord' => $task->getType() === TaskTypeEnum::ThreeNoteChord ? $task->getChord() : null,
                'shouldStudentRecogniseInversion' => $task->getType() === TaskTypeEnum::ThreeNoteChord ? $task->getShouldStudentRecogniseInversion() : false,
            ],
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $feedback = $this->taskAnswerService->handleAnswer($dto, $task);

            $this->addFlash(
                $feedback->getIsCorrect() ? 'success' : 'danger',
                $feedback->getFeedback(),
            );

            if ($feedback->getIsCorrect()) {
                $this->experienceStatisticService->addExperience($user, $feedback->getPoints());
            }

            if ($feedback->getIsCorrect()) {
                $award = $this->awardService->addAward($user, AwardEnum::CompletedFirstTask);
                if ($award) {
                    $this->addFlash(
                        'success',
                        $this->translator->trans('ui.message.awarded', [
                                '%name%' => $award->getType()->trans($this->translator),
                                '%points%' => AwardEnum::getPoints($award->getType())
                            ]
                        )
                    );
                }
            }


            if ($feedback->getIsCorrect() && $this->taskStatisticService->getCompletedTasksCountForNode($node, $user) === count($node->getTasks())) {
                $award = $this->awardService->addAward($user, AwardEnum::CompletedFirstNode);
                if ($award) {
                    $this->addFlash(
                        'success',
                        $this->translator->trans('ui.message.awarded', [
                                '%name%' => $award->getType()->trans($this->translator),
                                '%points%' => AwardEnum::getPoints($award->getType())
                            ]
                        )
                    );
                }
            }

            if ($feedback->getIsCorrect() && $this->courseService->hasUserCompletedAllNodes($user, $course)) {
                $award = $this->awardService->addAward($user, AwardEnum::CompletedFirstCourse);
                if ($award) {
                    $this->addFlash(
                        'success',
                        $this->translator->trans('ui.message.awarded', [
                                '%name%' => $award->getType()->trans($this->translator),
                                '%points%' => AwardEnum::getPoints($award->getType())
                            ]
                        )
                    );
                }
            }

            if ($feedback->getIsCorrect() && $nextTask) {
                return $this->redirectToRoute('task_show', ['slug' => $course->getSlug(), 'nodeSlug' => $node->getSlug(), 'taskSlug' => $nextTask->getSlug()]);
            }

            if ($feedback->getIsCorrect() && !$nextTask) {
                return $this->redirectToRoute('node_show', ['slug' => $course->getSlug(), 'nodeSlug' => $node->getSlug()]);
            }

            return $this->redirectToRoute('task_show', ['slug' => $course->getSlug(), 'nodeSlug' => $node->getSlug(), 'taskSlug' => $task->getSlug()]);
        }


        return $this->render(
            'task/show.html.twig',
            [
                'course' => $course,
                'node' => $node,
                'task' => $task,
                'form' => $form->createView(),
            ]
        );
    }

}
