<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
class IndexControllerAbstract extends AbstractBaseController
{
    #[Route(name: 'index', methods: 'GET')]
    public function index(Request $request): Response
    {
        return $this->render('index/index.html.twig');
    }
}
