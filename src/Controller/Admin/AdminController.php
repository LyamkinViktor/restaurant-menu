<?php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class AdminPageController
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * Admin panel index page.
     *
     * @Route("/admin", name="admin-panel")
     *
     * @param AuthenticationUtils $authenticationUtils Authentication utils instance.
     *
     * @return Response
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('admin-panel.html.twig',[
            'last_username' => $lastUsername,
        ]);
    }
}