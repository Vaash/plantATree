<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/my_account")
 */
class MyAccountController extends AbstractController
{
    /**
     * @Route("/", name="app_myAccount")
     */
    public function index()
    {
        $user = $this->getUser();

        return $this->render('my_account/index.html.twig', [
            'username' => $user->getUsername(),
        ]);
    }

    /**
     * @Route("/update_account", name="app_account_update")
     */
    public function update()
    {
        return $this->render('my_account/update.html.twig');
    }
}
