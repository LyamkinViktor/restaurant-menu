<?php

namespace App\Controller\Admin;

use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @param AuthenticationUtils    $authenticationUtils Authentication utils instance.
     * @param EntityManagerInterface $entityManager       Entity manager interface.
     * @param MenuRepository         $menuRepository      Menu repository.
     * @return Response
     */
    public function index(
        AuthenticationUtils $authenticationUtils,
        EntityManagerInterface $entityManager,
        MenuRepository $menuRepository
    ): Response {
        $lastUsername = $authenticationUtils->getLastUsername();
        $crudMenu = new CrudMenuController($entityManager, $menuRepository);

        return $this->render('admin/admin-panel.html.twig',[
            'last_username' => $lastUsername,
            'menus'         => $crudMenu->getMenuList(),
        ]);
    }
}