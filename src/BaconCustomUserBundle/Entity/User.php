<?php

namespace BaconCustomUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Bacon\Bundle\UserBundle\Entity\User as BaconUser;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class User
 * 
 * @package Bacon\Bundle\UserBundle\Entity
 *
 * @author Adan Felipe Medeiros<adan.grg@gmail.com>
 * @author Mateus Guerra<talk@mateusguerra.com>
 * @version 1.0
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class User extends BaconUser
{
    /**
     * @var integer
     */
    const PER_PAGE = 20;

    public function __construct()
    {
        parent::__construct();
        $this->addRole('ROLE_ADMIN');
    }
}