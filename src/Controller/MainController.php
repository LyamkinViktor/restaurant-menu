<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 * @package App\Controller
 */
class MainController extends AbstractController
{
    /**
     * Main page index.
     *
     * @Route("/main", name="main-page")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('main.html.twig');
    }
}