<?php
/**
 * Created by PhpStorm.
 * User: madhav
 * Date: 2019-03-06
 * Time: 21:44
 */

namespace App\Services;


use App\Entity\User;
use App\Repository\UserRepository;
use FOS\UserBundle\Model\UserManagerInterface;

class UserService
{

    private $repo;

    private $userManager;

    public function __construct(UserRepository $userRepository, UserManagerInterface $userManager)
    {
        $this->repo = $userRepository;
        $this->userManager = $userManager;
    }

    public function findAll() {
        return $this->repo->findAll();
    }

    public function findUser(User $user) {
        return $this->userManager->findUserByEmail($user->getEmail());
    }

    public function findUserById(string $id) {
        return $this->repo->find($id);
    }

    public function findUserByEmail(string $email) {
        return $this->userManager->findUserByEmail($email);
    }


    public function create(User $user) {
        // Check if the user exists to prevent Integrity constraint violation error in the insertion
        if($this->findUser($user)){
            return false;
        }
        // Use FOS User Manager to persist the user
        $this->userManager->updateUser($user);
    }

    public function update(User $user) {
        // Check if the user exist, if not cannot update
        if(!$this->findUser($user)){
            return false;
        }
        // Use FOS User Manager to persist the user
        $this->userManager->updateUser($user);
    }

    public function delete(User $user) {
        // Check if the user exist, if not cannot delete
        if(!$this->findUser($user)){
            return false;
        }
        // Use FOS User Manager to delete the user
        $this->userManager->deleteUser($user);
    }

}