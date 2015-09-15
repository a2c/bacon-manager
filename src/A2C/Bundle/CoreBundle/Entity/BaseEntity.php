<?php

namespace A2C\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use A2C\Bundle\CoreBundle\Model as ORMBehaviors;

/**
 * Class BaseEntity
 * @package AppBundle\Entity
 *
 * @ORM\MappedSuperclass()
 * @ORM\HasLifecycleCallbacks()
 */
abstract class BaseEntity
{
    use ORMBehaviors\Timestampable\Timestampable;

    const PER_PAGE = '20';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}