<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use App\Form\MenuFormType;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CrudMenuController
 *
 * @package App\Controller\Admin
 * @Route("/admin/menu")
 */
class CrudMenuController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var MenuRepository
     */
    private $menuRepository;

    /**
     * CrudMenuController constructor.
     *
     * @param EntityManagerInterface $entityManager  Entity manager interface.
     * @param MenuRepository         $menuRepository Menu repository.
     */
    public function __construct(EntityManagerInterface $entityManager, MenuRepository $menuRepository)
    {
        $this->entityManager  = $entityManager;
        $this->menuRepository = $menuRepository;
    }

    /**
     * Get available menus.
     *
     * @return Menu[]|object[]
     */
    public function getMenuList(): array
    {
        return $this->menuRepository->findAll();
    }

    /**
     * Create or update existing menu.
     *
     * @Route("/update/{id?}", name="update-menu", requirements={"id"="\d+"})
     *
     * @param Request  $request Request instance.
     * @param int|null $id      Editable menu id.
     *
     * @return RedirectResponse|Response
     */
    public function update(Request $request, ?int $id)
    {
        if (null !== $id) {
            $menu = $this->entityManager->getRepository(Menu::class)->find($id);
            if (!$menu) {
                $this->addFlash('error', 'Menu not found!');

                return $this->redirectToRoute('admin-panel');
            }
        } else {
            $menu = new Menu();
        }

        $form = $this->createForm(MenuFormType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $menu->setName($form->get('name')->getData());
            $menu->setEnabledFrom($form->get('enabledFrom')->getData());
            $menu->setEnabledUntil($form->get('enabledUntil')->getData());

            $this->entityManager->persist($menu);
            $this->entityManager->flush();

            return $this->redirectToRoute('admin-panel');
        }

        return $this->render('admin/update-menu.html.twig', [
            'menuForm' => $form->createView(),
        ]);
    }

    /**
     * Delete menu.
     *
     * @Route("/delete/{id}", name="delete-menu", requirements={"id"="\d+"})
     *
     * @param integer $id The identifier of the menu to be deleted.
     *
     * @return mixed
     */
    public function delete(int $id)
    {
        $menu = $this->entityManager->find(Menu::class, $id);
        if (!$menu) {
            $this->addFlash('error', 'Menu not found!');

            return $this->redirectToRoute('admin-panel');
        }
        $products = $menu->getProducts();
        if ($products->count() >= 1) {
            foreach ($products as $product) {
                $menu->removeProduct($product);
                $this->entityManager->remove($product);
            }
        }
        $this->entityManager->remove($menu);
        $this->entityManager->flush();
        $this->addFlash('success', 'Menu successfully deleted');

        return $this->redirectToRoute('admin-panel');
    }
}