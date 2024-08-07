<?php

namespace App\Controller;

use App\Service\Course\CourseServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractBaseController extends AbstractController
{
    public function __construct(
        private readonly CourseServiceInterface $courseService,
    )
    {
    }

    protected function render(string $view, array $parameters = [], ?Response $response = null): Response
    {
        $courses = $this->courseService->getMenuList();

        return parent::render($view, [...$parameters, 'courses' => $courses], $response);
    }
}
