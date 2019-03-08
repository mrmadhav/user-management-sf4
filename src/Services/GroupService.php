<?php
/**
 * Created by PhpStorm.
 * User: madhav
 * Date: 2019-03-06
 * Time: 21:44
 */

namespace App\Services;


use App\Entity\Group;
use App\Repository\GroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;

class GroupService
{

    private $repo;
    private $em;

    public function __construct(GroupRepository $groupRepository, EntityManagerInterface $em)
    {
        $this->repo = $groupRepository;
        $this->em = $em;
    }

    public function findAll() {
        return $this->repo->findAll();
    }

    public function findGroupById(?string $id) {
        if(is_null($id)) return false;
        return $this->repo->find($id);
    }

    public function findGroupByName(string $name) {
        return $this->repo->findOneBy(['name' => $name]);
    }


    public function create(Group $group) {
        // Check if the group exists to prevent Integrity constraint violation error in the insertion
        if($this->findGroupById($group->getId())){
            return false;
        }
        try {
            // Use Entity Manager to persist the group
            $this->em->persist($group);
            $this->em->flush($group);
        } catch (ORMException $e) {
            //$e->getTraceAsString(); // On production this should be logged
            return false;
        }
    }

    public function update(Group $group) {
        // Check if the group exists
        if(!$this->findGroupById($group->getId())){
            return false;
        }
        try {
            // Use Entity Manager to persist the group
            $this->em->persist($group);
            $this->em->flush($group);
        } catch (ORMException $e) {
            //$e->getTraceAsString(); // On production this should be logged
            return false;
        }
    }

    public function delete(Group $group) {
        // Check if the group exists
        if(!$this->findGroupById($group->getId())){
            return false;
        }
        try {
            // Use Entity Manager to remove the group
            $this->em->remove($group);
            $this->em->flush($group);
        } catch (ORMException $e) {
            //$e->getTraceAsString(); // On production this should be logged
            return false;
        }
    }
}