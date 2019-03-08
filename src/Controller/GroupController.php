<?php

namespace App\Controller;

use App\Entity\Group;
use App\Form\GroupType;
use App\Services\GroupService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GroupController extends AbstractController
{
    /**
     * @Route("/admin/group", name="group")
     */
    public function index()
    {
        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/admin/group/add", name="addGroup")
     */
    public function addGroup(Request $request, GroupService $groupService)
    {
        $group = new Group();
        return $this->handleForm($request, $groupService, $group);
    }

    /**
     * @Route("/admin/group/edit", name="editGroup")
     */
    public function editGroup(Request $request, GroupService $groupService)
    {
        $id = $request->get('id', null);
        if($id) {
            $group = $groupService->findGroupById($id);
            return $this->handleForm($request, $groupService, $group);
        } else {
            return $this->redirectToRoute('admin');
        }
    }

    /**
     * @Route("/admin/group/delete", name="deleteGroup")
     */
    public function deleteGroup(Request $request, GroupService $groupService)
    {
        $id = $request->get('id', null);
        if($id) {
            $group = $groupService->findGroupById($id);
            $groupService->delete($group);
        }
        return $this->redirectToRoute('admin');
    }

    private function handleForm(Request $request, GroupService $groupService, Group $group) {
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $group = $form->getData();
            if($groupService->findGroupByName($group->getName())) {
                $groupService->update($group);
            } else {
                $groupService->create($group);
            }
            return $this->redirectToRoute('admin');
        }
        return $this->render('group/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
