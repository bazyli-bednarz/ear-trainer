<?php

namespace App\Controller;

use App\Dto\Node\CreateNodeDto;
use App\Dto\Node\EditNodeDto;
use App\Dto\TaskError\TaskErrorListDto;
use App\Entity\Course;
use App\Entity\Node;
use App\Entity\Task\AbstractTask;
use App\Entity\User;
use App\Form\Type\Node\CreateNodeType;
use App\Form\Type\Node\EditNodeType;
use App\Service\Award\AwardServiceInterface;
use App\Service\Course\CourseServiceInterface;
use App\Service\Node\NodeServiceInterface;
use App\Service\Statistic\ExperienceStatisticServiceInterface;
use App\Service\Statistic\TaskErrorServiceInterface;
use App\Service\Task\TaskServiceInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/powtorka')]
class TaskErrorController extends AbstractBaseController
{
    public function __construct(
        CourseServiceInterface                     $courseService,
        TranslatorInterface                        $translator,
        ExperienceStatisticServiceInterface        $experienceStatisticService,
        AwardServiceInterface                      $awardService,
        private readonly TaskErrorServiceInterface $taskErrorService,
        private readonly Security                  $security,
        private readonly TaskServiceInterface      $taskService
    )
    {
        parent::__construct($courseService, $translator, $experienceStatisticService, $awardService);
    }


    #[Route(
        name: 'task_error_index',
        methods: ['GET'])
    ]
    public function index(
        Request $request
    ): Response
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $tasksErrors = $this->taskErrorService->getTaskErrorsByUser($user);
        $tasks = [];
        foreach ($tasksErrors as $tasksError) {
            $task = $this->taskService->getById($tasksError->getTaskId());
            if ($task) {
                if (!$task->getNode() || !$task->getNode()->getCourse()) {
                    continue;
                }
                $tasks[] = new TaskErrorListDto(
                    $task->getId(),
                    $task->getSlug(),
                    $task->getName(),
                    $task->getNode()->getSlug(),
                    $task->getNode()->getCourse()->getSlug(),
                    $task->getType(),
                    $task->getDescription(),
                );
            }

        }

        return $this->render(
            'task_error/index.html.twig',
            [
                'tasks' => $tasks,
            ]
        );
    }

    #[Route(
        '/{slug}/usun',
        name: 'task_error_delete',
        methods: ['GET', 'DELETE']
    )]
    public function deleteTask(
        #[MapEntity(mapping: ['slug' => 'slug'])] AbstractTask $task,
        Request                                                    $request
    ): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $taskError = $this->taskErrorService->getTaskError($task, $user);
        if (!$taskError) {
            $this->addFlash(
                'danger',
                $this->translator->trans('ui.message.taskNotFound')
            );
            return $this->redirectToRoute('task_error_index');
        }

        $deletedTaskName = $task->getName();
        $this->taskErrorService->delete($taskError);

        $this->addFlash(
            'success',
            $this->translator->trans('ui.message.deleted.taskError', ['%name%' => $deletedTaskName])
        );

        return $this->redirectToRoute('task_error_index');
    }
}
