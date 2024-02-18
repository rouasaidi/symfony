<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackdonController extends AbstractController
{
    #[Route('/feedbackdon', name: 'app_feedbackdon')]
    public function index(): Response
    {
        return $this->render('feedbackdon/index.html.twig', [
            'controller_name' => 'FeedbackdonController',
        ]);
    }
}
