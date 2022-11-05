<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{    public function __construct(private ManagerRegistry $doctrine)
    {

    }

    
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->renderForm('home/index.html.twig');
    }
}
