<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\GroupRepository;
use App\Repository\UserRepository;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(UserService $userService, GroupRepository $groupRepository)
    {
        $listOfUsers = $userService->findAll();
        $listOfGroups = $groupRepository->findAll();
        return $this->render('admin/index.html.twig', [
            'listOfUsers' => $listOfUsers,
            'listOfGroups' => $listOfGroups
        ]);
    }
}
