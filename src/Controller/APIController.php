<?php
/**
 * Created by PhpStorm.
 * User: madhav
 * Date: 2019-03-08
 * Time: 12:39
 */

namespace App\Controller;

use App\Entity\Group;
use App\Entity\User;
use App\Services\GroupService;
use App\Services\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class APIController extends AbstractFOSRestController
{

    /**
     * @Rest\Get("/api/user")
     */
    public function getUserList(UserService $userService)
    {
        $users = $userService->findAll();
        $listOfUsers = [];
        /* @var $user User */
        foreach ($users as $user) {
            $userGroups = [];
            /* @var $userGroup Group */
            foreach ($user->getUserGroups() as $userGroup) {
                $userGroups[] = [
                    "id" => $userGroup->getId(),
                    "name" => $userGroup->getName()
                ];
            }
            $listOfUsers[] = [
                "id" => $user->getId(),
                "username" => $user->getUsername(),
                "name" => $user->getName(),
                "groups" => $userGroups
            ];
        }
        return $listOfUsers;
    }

    /**
     * @Rest\Post("/api/user")
     */
    public function createUser() {
        return "Not yet implemented";
    }

    /**
     * @Rest\Put("/api/user")
     */
    public function updateUser() {
        return "Not yet implemented";
    }

    /**
     * @Rest\Delete("/api/user")
     */
    public function deleteUser() {
        return "Not yet implemented";
    }

    /**
     * @Rest\Get("/api/group")
     */
    public function getGroupList(GroupService $groupService)
    {
        $groups = $groupService->findAll();
        $listOfGroups = [];
        /* @var $group Group */
        foreach ($groups as $group) {
            $groupUsers = [];
            /* @var $user User */
            foreach ($group->getUsers() as $user) {
                $groupUsers[] = [
                    "id" => $user->getId(),
                    "username" => $user->getUsername(),
                    "name" => $user->getName(),
                ];
            }
            $listOfGroups[] = [
                "id" => $group->getId(),
                "name" => $group->getName(),
                "users" => $groupUsers
            ];
        }
        return $listOfGroups;
    }

    /**
     * @Rest\Post("/api/group")
     */
    public function createGroup() {
        return "Not yet implemented";
    }

    /**
     * @Rest\Put("/api/group")
     */
    public function updateGroup() {
        return "Not yet implemented";
    }

    /**
     * @Rest\Delete("/api/group")
     */
    public function deleteGroup() {
        return "Not yet implemented";
    }

}