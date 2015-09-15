<?php

namespace A2C\Bundle\CoreBundle\Model\Timestampable;

use Doctrine\ORM\Mapping as ORM;

trait Timestampable
{
    /**
     * @ORM\Column(name="created_at",type="datetime",nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated_at",type="datetime",nullable=true)
     */
    protected $updatedAt;

    /**
     * @ORM\PrePersist()
     * @return $this
     */
    public function created()
    {
        $this->createdAt = new \DateTime('now');

        return $this;
    }

    /**
     * @ORM\PreUpdate()
     * @return $this
     */
    public function updated()
    {
        $this->updatedAt = new \DateTime('now');

        return $this;
    }

}