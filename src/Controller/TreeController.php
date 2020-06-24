<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Tree;
use App\Form\PlantTreeFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/my_account")
 */
class TreeController extends AbstractController
{
    /**
     * @Route("/plant_a_tree", name="app_plant_a_tree")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function plantATree(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();

        $tree = new Tree();
        $tree->setUser($user);
        $form = $this->createForm(PlantTreeFormType::class, $tree);
        $form->handleRequest($request);

        $treeRepository = $this->getDoctrine()->getRepository(Tree::class);
        $treeList = $treeRepository->findBy(['user' => $user->getId()]);

        if ($form->isSubmitted() && $form->isValid()) {
            $tree->setDate(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tree);
            $entityManager->flush();
            $treeList = $treeRepository->findBy(['user' => $user->getId()]);

            $this->addFlash('success', 'We will plant this tree !');
        } elseif ($form->isSubmitted() && $form === null) {
            $this->addFlash('error', 'An error occurred, please try again.');
        }

        return $this->render('tree/plant.html.twig', [
            'plantTreeForm' => $form->createView(),
            'treeList' => $treeList
        ]);
    }

    /**
     * @Route("/trees/delete/{id}", name="app_trees_delete_tree")
     * @param $id
     */
    public function deleteTree($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $tree = $this->getDoctrine()->getRepository(Tree::class)->find($id);
        if ($tree !== null) {
            $entityManager->remove($tree);
            $entityManager->flush();

            $this->addFlash('success', 'Tree successfully deleted.');
        } else {
            $this->addFlash('error', 'Tree doesnt exist.');
        }
        return $this->redirectToRoute('app_account');
    }

    /**
     * @Route("/insert")
     */
    public function insert()
    {
        /** @var User $user */
        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();

        for ($i = 0; $i < 21; $i++) {
            $tree = new Tree();
            $tree->setLatitude(36.54367);
            $tree->setLongitude(36.46886);
            $tree->setDate(new \DateTime());
            $tree->setUser($user);

            $entityManager->persist($tree);
        }
        $entityManager->flush();
        return $this->redirectToRoute('app_account');
    }
}
