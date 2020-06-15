<?php

namespace App\Menu;

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
        $menu = $this->factory->createItem('myAccount');
        $user = $this->security->getUser();

        $menu->addChild('Home', ['route' => 'app_home']);
        if ($user === null) {
            $menu->addChild('Login', ['route' => 'app_login']);
        } else {
            $menu->addChild('Logout', ['route' => 'app_logout']);
            $menu->addChild('My Account', ['route' => 'app_myAccount']);
        }
        return $menu;
    }

    public function createSidebarMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('sidebar');

        $menu->addChild('Home', ['route' => 'homepage']);
        // ... add more children

        return $menu;
    }
}