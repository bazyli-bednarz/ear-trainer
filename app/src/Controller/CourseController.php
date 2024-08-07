<?php

namespace App\Controller;

use App\Entity\Course;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/kursy')]
class CourseController extends AbstractBaseController
{
    #[Route('/', name: 'course_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        return $this->render('course/index.html.twig');
    }

    #[Route(
        '/{slug}',
        name: 'course_show',
        methods: ['GET'])
    ]
    public function show(Course $course, Request $request): Response
    {
        return $this->render(
            'course/show.html.twig',
            [
                'course' => $course,
            ]
        );
    }
}
