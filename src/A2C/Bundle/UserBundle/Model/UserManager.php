<?php

namespace A2C\Bundle\UserBundle\Model;

use Symfony\Component\DependencyInjection\ContainerInterface;
use A2C\Bundle\UserBundle\Entity\User;

/**
 * Class UserManager
 * @package A2C\Bundle\UserBundle\Model
 */
class UserManager
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var User
     */
    protected $entity = null;


    /**
     * @return bool
     * @throws \Exception
     */
    public function saveUser()
    {
        if ($this->getEntity() === null) {
            throw new \Exception("Not Entity!");
        }

        $user = $this->getEntity();

        $password = $user->getPassword();
        $enconder = $this->getContainer()->get('security.password_encoder');
        $newPassword = $enconder->encodePassword($user,$password);
        $user->setPassword($newPassword);

        try {
            $this->getContainer()->get('doctrine')->getManager()->persist($user);
            $this->getContainer()->get('doctrine')->getManager()->flush();

            return true;

        }catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @return User
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param User $entity
     */
    public function setEntity(User $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }
}