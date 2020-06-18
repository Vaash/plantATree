<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserRoleChangeFormType;
use ContainerBpucrjm\getUserRepositoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="app_admin")
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $admin = $this->getUser();

        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $userList = $userRepository->findAll();

        $arrayOfForms = [];

        foreach ($userList as $user) {
            $form = $this->createForm(UserRoleChangeFormType::class, $user, [
                'action' => $this->generateUrl('app_admin_user_change_role', [
                    'id' => $user->getId(),
                ])
            ]);

            $viewForm = $form->createView();
            array_push($arrayOfForms, $viewForm);
        }

//        dump($request);
//        die;

        return $this->render('admin/index.html.twig', [
            'adminName' => $admin->getUsername(),
            'userList' => $userList,
            'userRoleChangeFormArray' => $arrayOfForms
        ]);
    }

    /**
     * @Route("/user/delete/{id}", name="app_admin_delete_user")
     * @param $id
     */
    public function deleteUser($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        if ($user !== null) {
            $em->remove($user);
            $em->flush();

            $this->addFlash('success', 'User successfully deleted');
        } else {
            $this->addFlash('error', 'User doesnt exist.');
        }
        return $this->redirectToRoute('app_admin');
    }

    /**
     * @Route("/insert")
     */
    public function insert()
    {
        $em = $this->getDoctrine()->getManager();

        for ($i = 0; $i < 21; $i++) {
            $user = new User();
            $user->setBirthDate(new \DateTime());
            $user->setEmail('b' . $i . '@gmail.com');
            $user->setFirstName('jean');
            $user->setLastName('jacques');
            $user->setPassword('a' . $i);

            $em->persist($user);
        }
        $em->flush();
        return $this->redirectToRoute('app_admin');
    }

    /**
     * @Route("/user/change-role", name="app_admin_user_change_role")
     * @param Request $request
     */
    public function changeRole(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserRoleChangeFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userId = $request->query->get('id');
            $userToChange = $this->getDoctrine()->getRepository(User::class)->find($userId);
            if ($userToChange === null) {
                $this->addFlash('error', 'Error');
            } else {
                $userToChange->setRoles($user->getRoles());
                $em = $this->getDoctrine()->getManager();
                $em->persist($userToChange);
                $em->flush();

                $this->addFlash('success', 'Success');
            }
        }
        return $this->redirectToRoute('app_admin');
    }
}
