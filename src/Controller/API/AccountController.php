<?php

namespace App\Controller\API;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AccountController
 * @package App\Controller\API
 * @IsGranted("ROLE_USER")
 */
class AccountController extends AbstractController
{
    /**
     * @Route("/api/account", name="api_account")
     */
    public function accountApi(): JsonResponse
    {
        $user = $this->getUser();

        return $this->json($user);
    }
}