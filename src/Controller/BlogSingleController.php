<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogSingleController extends AbstractController
{
<<<<<<< HEAD
    #[Route('/blog/single', name: 'app_blog_single')]
=======
    #[Route('/blog_single', name: 'app_blog_single')]
>>>>>>> Dev_masters-3A57/malek
    public function index(): Response
    {
        return $this->render('blog_single/index.html.twig', [
            'controller_name' => 'BlogSingleController',
        ]);
    }
}
