<?php

namespace App\Controller;

use App\Entity\Tree;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $trees = $this->getDoctrine()->getRepository(Tree::class)->findAll();

        $treeRepository = $this->getDoctrine()->getRepository(Tree::class);
        $treeList = $treeRepository->findAll();

        $numberOfUsers = count($users);
        $numberOfTrees = count($trees);

        return $this->render('home_page/index.html.twig', [
            'numberOfTrees' => $numberOfTrees,
            'numberOfUsers' => $numberOfUsers,
            'treeList' => $treeList
        ]);
    }
}
