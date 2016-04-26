<?php

namespace Bacon\Custom\UserBundle\Entity;

use Bacon\Bundle\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="Bacon\Custom\UserBundle\Repository\UserRepository")
 * @ORM\Table(name="auth_user")
 */
class User extends BaseUser
{

}
