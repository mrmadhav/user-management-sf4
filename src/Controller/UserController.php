<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\User;
use App\Form\UserType;
use App\Services\GroupService;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="user")
     */
    public function index()
    {
        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/admin/user/add", name="addUser")
     */
    public function addUser(Request $request, UserService $userService, GroupService $groupService)
    {
        $user = new User();
        return $this->handleForm($request, $userService, $groupService, $user);
    }
    /**
     * @Route("/admin/user/edit", name="editUser")
     */
    public function editUser(Request $request, UserService $userService, GroupService $groupService)
    {
        $id = $request->get('id', null);
        if($id) {
            $user = $userService->findUserById($id);
            return $this->handleForm($request, $userService, $groupService, $user);
        } else {
            return $this->redirectToRoute('admin');
        }
    }
    /**
     * @Route("/admin/user/delete", name="deleteUser")
     */
    public function deleteUser(Request $request, UserService $userService)
    {
        $id = $request->get('id', null);
        if($id) {
            $user = $userService->findUserById($id);
            $userService->delete($user);
        }
        return $this->redirectToRoute('admin');
    }
    private function handleForm(Request $request, UserService $userService, GroupService $groupService, User $user) {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            // Clean up groups first
            /* @var $group Group */
            foreach ($groupService->findAll() as $group) {
                $group->removeUser($user);
                $groupService->update($group);
            }
            // Now add the user to the group if necessary
            /* @var $userGroup Group */
            foreach ($user->getUserGroups() as $userGroup) {
                $userGroup->addUser($user);
                $groupService->update($userGroup);
            }
            if($userService->findUser($user)) {
                $userService->update($user);
            } else {
                $userService->create($user);
            }
            return $this->redirectToRoute('admin');
        }
        return $this->render('user/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
