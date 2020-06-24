<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\MenuItem;
use Symfony\Component\Security\Core\Security;

class MenuBuilder
{
    private $factory;
    private $security;

    /**
     * @param FactoryInterface $factory
     * @param $security
     */
    public function __construct(FactoryInterface $factory, Security  $security)
    {
        $this->factory = $factory;
        $this->security = $security;
    }

    public function createMainMenu()
    {
        $menu = $this->factory->createItem('mainMenu');
        $user = $this->security->getUser();

        $menu->setChildrenAttribute('class', 'navbar-nav mr-auto');

        $menu->addChild('Home', ['route' => 'app_home']);
        if ($user === null) {
            $menu->addChild('Login', ['route' => 'app_login']);
            $menu->addChild('Sign up', ['route' => 'app_register']);
        } else {
            $menu->addChild('My Account', ['route' => 'app_account']);
            $menu->addChild('Plant A Tree!', ['route' => 'app_plant_a_tree']);
            if ($this->security->isGranted('ROLE_ADMIN')) {
                $menu->addChild('Admin', ['route' => 'app_admin']);
            }
            $menu->addChild('Logout', ['route' => 'app_logout']);
        }

        /** @var MenuItem $menuItem */
        foreach ($menu as $menuItem) {
            $menuItem->setLinkAttribute('class', 'nav-link');
            $menuItem->setAttribute('class', 'nav-item');
        }
        return $menu;
    }

    public function createMyAccountMenu()
    {
        $menu = $this->factory->createItem('myAccountMenu');

        $menu->setChildrenAttribute('class', 'nav');
        $menu->addChild('Change my data', ['route' => 'app_account_update']);
        $menu['Change my data']->setLinkAttribute('class', 'nav-link underline');
        $menu['Change my data']->setAttribute('class', 'nav-item');

        return $menu;
    }
}