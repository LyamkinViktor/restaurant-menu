<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminPageController
 */
class AdminController extends AbstractController
{
    /**
     * Admin panel index page.
     *
     * @Route("/admin", name="admin-panel")
     */
    public function index(): Response
    {
        return $this->render('admin-panel.html.twig');
    }
}