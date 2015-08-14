<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\PostRepository")
 * @ORM\Table(name="post")
 */
class Post extends BaseEntity
{
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category",inversedBy="id")
     **/
    protected $category;

    /**
     * @ORM\Column(name="date_published",type="datetime")
     */
    protected $date;

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}