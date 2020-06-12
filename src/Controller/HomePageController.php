<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index()
    {
        $user = $this->getUser();

        return $this->render('home_page/index.html.twig', [
            'controller_name' => $user->getUsername(),
        ]);
    }
}
