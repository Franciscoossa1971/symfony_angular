<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hola', name: 'app_hola')]
    public function index(): Response
    {
        return $this->render('hello/index.html.twig', [
            'message' => '¡Bienvenidos a Symfony!'
        ]);
    }
}