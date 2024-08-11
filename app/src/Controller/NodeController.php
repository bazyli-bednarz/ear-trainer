<?php

namespace App\Controller;

use App\Dto\Node\CreateNodeDto;
use App\Dto\Node\EditNodeDto;
use App\Entity\Node;
use App\Form\Type\Node\CreateNodeType;
use App\Form\Type\Node\EditNodeType;
use App\Service\Course\CourseServiceInterface;
use App\Service\Node\NodeServiceInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/lekcje')]
class NodeController extends AbstractBaseController
{
    public function __construct(
        CourseServiceInterface $courseService,
        private readonly TranslatorInterface $translator,
        private readonly NodeServiceInterface $nodeService,
    )
    {
        parent::__construct($courseService);
    }





}
