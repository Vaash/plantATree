<?php

namespace App\Menu;

use http\Url;
use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
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

    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('mainMenu');
        $user = $this->security->getUser();

        $menu->addChild('Home', ['route' => 'app_home']);
        if ($user === null) {
            $menu->addChild('Login', ['route' => 'app_login']);
            $menu->addChild('Sign up', ['route' => 'app_register']);
        } else {
            $menu->addChild('My Account', ['route' => 'app_account']);
            $menu->addChild('Logout', ['route' => 'app_logout']);
            $menu->addChild('Plant A Tree!', ['route' => 'app_plant_a_tree']);
            if ($this->security->isGranted('ROLE_ADMIN')) {
                $menu->addChild('Admin', ['route' => 'app_admin']);
            }
        }
        return $menu;
    }

    public function createMyAccountMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('myAccountMenu');

        $menu->addChild('Change my data', ['route' => 'app_account_update']);
        $menu->addChild('My trees', ['route' => 'app_trees']);

        return $menu;
    }
}