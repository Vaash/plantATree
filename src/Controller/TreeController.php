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
     * @Route("/", name="app_tree")
     */
    public function index()
    {
        $user = $this->getUser();

        return $this->render('tree/index.html.twig', [
            'username' => $user->getUsername(),
        ]);
    }

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

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tree);
            $entityManager->flush();
        }

        return $this->render('tree/plant.html.twig', [
            'plantTreeForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/trees", name="app_trees")
     * @param Request $request
     */
    public function myTrees(Request $request)
    {

        $treeRepository = $this->getDoctrine()->getRepository(Tree::class);
        $treeList = $treeRepository->findAll();

        return $this->render('tree/trees.html.twig', [
            'treeList' => $treeList
        ]);
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
        return $this->redirectToRoute('app_tree');
    }
}
