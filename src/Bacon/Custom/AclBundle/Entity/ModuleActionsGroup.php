<?php

namespace Bacon\Custom\AclBundle\Entity;

use Bacon\Bundle\AclBundle\Model\ModuleActionsGroupInterface;
use Bacon\Bundle\CoreBundle\Entity\BaseEntity;
use Bacon\Custom\UserBundle\Entity\Group;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Bacon\Custom\AclBundle\Repository\ModuleActionsGroupRepository")
 * @ORM\Table(name="module_actions_has_group")
 */
class ModuleActionsGroup extends BaseEntity implements ModuleActionsGroupInterface
{
    /**
     * @var boolean
     * @ORM\Column(name="enabled", type="boolean", options={"default" : 0}, nullable=false)
     */
    private $enabled;

    /**
     * @var Group
     *
     * @ORM\ManyToOne(targetEntity="\Bacon\Custom\UserBundle\Entity\Group")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id" ,nullable=false)
     */
    private $group;

    /**
     * @var \Bacon\Bundle\AclBundle\Entity\Module
     *
     * @ORM\ManyToOne(targetEntity="Bacon\Bundle\AclBundle\Entity\Module")
     * @ORM\JoinColumn(name="module_id", referencedColumnName="id", nullable=false)
     */
    private $module;

    /**
     * @var \AppBundle\Entity\ModuleActions
     *
     * @ORM\ManyToOne(targetEntity="Bacon\Custom\AclBundle\Entity\ModuleActions")
     * @ORM\JoinColumn(name="module_actions_id", referencedColumnName="id" ,nullable=false)
     */
    private $moduleActions;

    /**
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     * @return ModuleActionsUsers
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param Group $group
     * @return ModuleActionsUsers
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return \Bacon\Bundle\AclBundle\Entity\Module
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param \Bacon\Bundle\AclBundle\Entity\Module $module
     * @return ModuleActionsUsers
     */
    public function setModule($module)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * @return ModuleActions
     */
    public function getModuleActions()
    {
        return $this->moduleActions;
    }

    /**
     * @param ModuleActions $moduleActions
     * @return ModuleActionsUsers
     */
    public function setModuleActions($moduleActions)
    {
        $this->moduleActions = $moduleActions;

        return $this;
    }
}
