<?php

namespace App\Controller\Security;

use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class LoginController
 * @package App\Controller\Security
 */
class LoginController extends AbstractController
{
    /**
     * Login controller.
     *
     * @Route("/login", name="app_login")
     *
     * @param AuthenticationUtils $authenticationUtils Authentication Utils instance.
     *
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * Logout.
     *
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
    }
}