<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function index1(): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!$this->security->isGranted('ROLE_USER')) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            return $this->redirectToRoute('app_login');
        }

        // Afficher la page d'accueil normale si l'utilisateur est connecté
        return $this->render('home/index.html.twig');
    }
}
