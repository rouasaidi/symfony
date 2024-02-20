<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(): Response
    {
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error,
        ]);
    }
   /* #[Route('/redirect-after-login', name: 'redirect_after_login')]
    public function redirectAfterLogin(): RedirectResponse
    {
    $user = $this->getUser();
    if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
        return $this->redirectToRoute('app_user'); 
    }
    return $this->redirectToRoute('app_index');
    }*/
}
