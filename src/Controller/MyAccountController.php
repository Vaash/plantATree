<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserUpdateFormType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/my_account")
 */
class MyAccountController extends AbstractController
{
    /**
     * @Route("/", name="app_account")
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
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserUpdateFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('my_account/update.html.twig', [
            'userUpdateForm' => $form->createView(),
        ]);
    }
}
