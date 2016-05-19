<?php

namespace Bacon\Custom\UserBundle\Entity;

use Bacon\Bundle\UserBundle\Entity\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Bacon\Custom\UserBundle\Repository\UserRepository")
 * @ORM\Table(name="auth_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\ManyToMany(targetEntity="\Bacon\Custom\UserBundle\Entity\Group")
     * @ORM\JoinTable(name="auth_user_has_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->groups = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return Group
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param Group $groups
     * @return User
     */
    public function setGroups($groups)
    {
        $this->groups[] = $groups;

        return $this;
    }
}
