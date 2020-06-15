<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MyAccountController extends AbstractController
{
    /**
     * @Route("/my_account", name="app_myAccount")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        return $this->render('my_account/index.html.twig', [
            'username' => $user->getUsername(),
        ]);
    }
}
