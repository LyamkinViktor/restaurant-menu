<?php

namespace App\Controller\Response;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiResponseController
 * @package App\Controller
 */
class ApiResponseController extends AbstractController
{
    /**
     * If success.
     *
     * @param string|null $description Success description.
     *
     * @return JsonResponse
     */
    public static function success(?string $description): JsonResponse
    {
        return new JsonResponse(
            [
                'status'      => 'Success',
                'description' => $description ?? 'Operation completed',
            ],
            Response::HTTP_OK,
        );
    }

    /**
     * If not found.
     *
     * @return JsonResponse
     */
    public static function notFound(): JsonResponse
    {
        return new JsonResponse(
            [
                'status'      => 'Not found',
                'description' => 'Resource not found',
            ],
            Response::HTTP_NOT_FOUND,
        );
    }
}