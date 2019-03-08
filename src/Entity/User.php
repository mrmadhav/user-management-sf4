<?php
//src/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="um_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Group", mappedBy="users", cascade={"persist"})
     */
    private $user_groups;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $name;

    public function __construct()
    {
        parent::__construct();
        $this->user_groups = new ArrayCollection();
    }

    /**
     * @return Collection|Group[]
     */
    public function getUserGroups(): Collection
    {
        return $this->user_groups;
    }

    public function addUserGroup(Group $userGroup): self
    {
        if (!$this->user_groups->contains($userGroup)) {
            $this->user_groups[] = $userGroup;
            $userGroup->addUser($this);
        }

        return $this;
    }

    public function removeUserGroup(Group $userGroup): self
    {
        if ($this->user_groups->contains($userGroup)) {
            $this->user_groups->removeElement($userGroup);
            $userGroup->removeUser($this);
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}