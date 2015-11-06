<?php

namespace A2C\Bundle\LanguageBundle\Entity;

use A2C\Bundle\CoreBundle\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Language
 * @package A2C\Bundle\LanguageBundle\Entity
 * @ORM\Entity(repositoryClass="A2C\Bundle\LanguageBundle\Entity\Repository\LanguageRepository")
 * @ORM\Table(name="language")
 */
class Language extends BaseEntity
{

    /**
     * @ORM\Column(name="name",type="string",length=150,nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(name="acron",type="string",length=2,nullable=false)
     */
    private $acron;

    /**
     * @ORM\Column(name="locale",type="string",length=5,nullable=false)
     */
    private $locale;

    /**
     * @ORM\Column(name="image",type="string",length=150,nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(name="order_by",type="integer",nullable=true)
     */
    private $orderBy;

    /**
     * @ORM\Column(name="published",type="boolean")
     */
    private $published = false;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getAcron()
    {
        return $this->acron;
    }

    /**
     * @param string $acron
     */
    public function setAcron($acron)
    {
        $this->acron = $acron;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param int $orderBy
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    /**
     * @return bool
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @param bool $published
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }
}