<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="app_admin")
     */
    public function index()
    {
        $admin = $this->getUser();

        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $userList = $userRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'adminName' => $admin->getUsername(),
            'userList' => $userList,
        ]);
    }

    /**
     * @Route("/admin/{id}", name="app_admin_delete_user")
     * @param $id
     */
    public function deleteUser($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        $em->remove($user);
        $em->flush();

        return $this->index();
    }
}
