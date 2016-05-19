<?php

namespace Bacon\Custom\AclBundle\Entity;

use Bacon\Bundle\AclBundle\Entity\ModuleActions as BaseModuleActions;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ModuleActions
 *
 * @package Bacon\Custom\AclBundle\Entity
 * @ORM\Table(name="module_actions")
 * @ORM\Entity(repositoryClass="Bacon\Custom\AclBundle\Repository\ModuleActionsRepository")
 */
class ModuleActions extends BaseModuleActions
{
    /**
     * @ORM\ManyToOne(targetEntity="Bacon\Bundle\AclBundle\Entity\Module")
     * @ORM\JoinColumn(name="module_id", referencedColumnName="id" ,nullable=false)
     */
    private $module;

    /**
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param mixed $module
     * @return Module
     */
    public function setModule($module)
    {
        $this->module = $module;

        return $this;
    }
}
