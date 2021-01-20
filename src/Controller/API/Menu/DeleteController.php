<?php

namespace App\Controller\API\Menu;

use App\Controller\Response\ApiResponseController;
use App\Entity\Menu;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DeleteController
 * @package App\Controller\API\Menu
 */
class DeleteController extends AbstractController
{
    /**
     * @Route("/api/menus/{id}", methods={"DELETE"})
     *
     * @param $id
     *
     * @return JsonResponse
     */
    public function __invoke($id): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $menu = $entityManager->find(Menu::class, $id);
        if (!$menu) {
            return ApiResponseController::notFound();
        }
        $products = $menu->getProducts();
        if ($products->count() >= 1) {
            foreach ($products as $product) {
                $menu->removeProduct($product);
                $entityManager->remove($product);
            }
            $entityManager->remove($menu);
            $entityManager->flush();
        }

        return ApiResponseController::success();
    }
}