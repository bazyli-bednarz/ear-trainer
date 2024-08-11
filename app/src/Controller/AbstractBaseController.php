<?php

namespace App\Controller;

use App\Entity\Enum\TaskTypeEnum;
use App\Service\Course\CourseServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractBaseController extends AbstractController
{
    public function __construct(
        protected readonly CourseServiceInterface $courseService,
        protected readonly TranslatorInterface    $translator,
    )
    {
    }

    protected function render(string $view, array $parameters = [], ?Response $response = null): Response
    {
        $courses = $this->courseService->getMenuList();

        $taskTypes = [];
        foreach (TaskTypeEnum::cases() as $case) {
            $taskTypes[] = [
                'type' => $case->value,
                'label' => $case->trans($this->translator),
            ];
        }

        return parent::render($view, [...$parameters, 'courses' => $courses, 'taskTypes' => $taskTypes], $response);
    }
}
