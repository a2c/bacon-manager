<?php

namespace A2C\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use A2C\Bundle\CoreBundle\Entity\BaseEntity;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * @package A2C\Bundle\UserBundle\Entity
 *
 * @author Adan Felipe Medeiros<adan.grg@gmail.com>
 * @version 1.0
 *
 * @ORM\Entity()
 * @ORM\Table(name="user")
 */
class User extends BaseEntity implements UserInterface,\Serializable
{
    /**
     * @ORM\Column(name="username",type="string",length=120,nullable=false)
     */
    protected $username;

    /**
     * @ORM\Column(name="password",type="string",length=255,nullable=false)
     */
    protected $password;

    /**
     * @ORM\Column(name="email",type="string",length=200,nullable=false)
     */
    protected $email;

    /**
     * @ORM\Column(name="logged",type="datetime",nullable=true)
     */
    protected $logged;

    /**
     * @ORM\Column(name="roles",type="string",length=25,nullable=false)
     */
    protected $roles;

    /**
     * @ORM\Column(name="gravatar",type="string",length=255,nullable=true)
     */
    protected $gravatar;

    /**
     * @ORM\Column(name="active",type="boolean",nullable=false)
     */
    protected $active;

    public function serialize()
    {
        // TODO: Implement serialize() method.
    }

    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
    }

    public function getRoles()
    {
        return explode(',',$this->roles);
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        return;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getLogged()
    {
        return $this->logged;
    }

    /**
     * @param mixed $logged
     */
    public function setLogged($logged)
    {
        $this->logged = $logged;
    }

    /**
     * @return mixed
     */
    public function getGravatar()
    {
        return $this->gravatar;
    }

    /**
     * @param mixed $gravatar
     */
    public function setGravatar($gravatar)
    {
        $this->gravatar = $gravatar;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }
}