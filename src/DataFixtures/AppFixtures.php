<?php

namespace App\DataFixtures;

use App\Entity\Menu;
use App\Entity\Product;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        //Create admin user:
        $user = new User();
        $user->setEmail('admin@example.com');
        $user->setPassword($this->encoder->encodePassword($user, 'admin'));
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);
        $manager->flush();

        //Create breakfast menu:
        $startBreakfast = new DateTime('2021-01-01');
        $startBreakfast->setTime(9,00);
        $endBreakfast = new DateTime('2022-01-01');
        $endBreakfast->setTime(12,00);
        $this->createMenu($manager, 'Breakfast', $startBreakfast, $endBreakfast);

        //Create lunch menu:
        $startLunch = new DateTime('2021-01-01');
        $startLunch->setTime(12,00);
        $endLunch = new DateTime('2022-01-01');
        $endLunch->setTime(18,00);
        $this->createMenu($manager, 'Lunch', $startLunch, $endLunch);

        //Create dinner menu:
        $startDinner = new DateTime('2021-01-01');
        $startDinner->setTime(18,00);
        $endDinner = new DateTime('2022-01-01');
        $endDinner->setTime(21,00);
        $this->createMenu($manager, 'Dinner', $startDinner, $endDinner);
    }

    /**
     * Create fixtures menu.
     *
     * @param ObjectManager $manager          Object manager instance.
     * @param string        $menuName         Name of new menu.
     * @param DateTime      $enabledFromDate  Menu start date.
     * @param DateTime      $enabledUntilDate Menu end date.
     */
    public function createMenu(
        ObjectManager $manager,
        string $menuName,
        DateTime $enabledFromDate,
        DateTime $enabledUntilDate
    ):void {
        $menu = new Menu();
        $menu->setName($menuName);
        $menu->setEnabledFrom($enabledFromDate);
        $menu->setEnabledUntil($enabledUntilDate);
        for ($i = 1; $i < 4; $i++) {
            $product = new Product();
            $product->setName($menuName.' product '.$i);
            $product->setMenu($menu);
            $product->setPosition($i);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
