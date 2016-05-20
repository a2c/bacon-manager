<?php

namespace Bacon\Custom\AclBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadModuleActionsGroupData
 * @package Bacon\Custom\AclBundle\DataFixtures\ORM
 * @author Adan Felipe Medeiros <adan.grg@gmail.com>
 */
class LoadModuleActionsGroupData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $groups = $this->getGroups();
        $modules = $this->getModulesDefault();

        $className = $this->container->getParameter('bacon_acl.entities.module_actions_group');

        $actionsDefault = [
            'INDEX',
            'NEW',
            'EDIT',
            'SHOW',
            'DELETE',
        ];

        foreach ($groups as $group) {
            foreach ($modules as $module) {
                foreach ($actionsDefault as $action) {
                    $actionsGroup = $this->getReference('module-actions-'.$module->getSlug().'-'.$action);

                    $objSave = new $className();
                    $objSave->setEnabled(true);
                    $objSave->setGroup($group);
                    $objSave->setModule($module);
                    $objSave->setModuleActions($actionsGroup);

                    $manager->persist($objSave);
                }
            }

            $this->executeUserACL($group, $manager);
            $this->executeACL($group, $manager);
        }

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 4;
    }

    /**
     * @return array
     */
    private function getGroups()
    {
        $groups = [];
        $groups[] = $this->getReference('admin-group');

        return $groups;
    }

    /**
     * @return array
     */
    private function getModulesDefault()
    {
        $modules = [];

        $modules[] = $this->getReference('module-name-module');
        $modules[] = $this->getReference('module-name-module-actions');
        $modules[] = $this->getReference('module-name-groups');

        return $modules;
    }

    /**
     * @param $group
     * @param $manager
     */
    private function executeACL($group, $manager)
    {
        $modules = $this->getReference('module-name-acl');

        $className = $this->container->getParameter('bacon_acl.entities.module_actions_group');
        $actionsGroup = $this->getReference('module-actions-'.$modules->getSlug().'-ACL');

        $objSave = new $className();
        $objSave->setEnabled(true);
        $objSave->setGroup($group);
        $objSave->setModule($modules);
        $objSave->setModuleActions($actionsGroup);

        $manager->persist($objSave);
    }

    /**
     * @param $group
     * @param $manager
     */
    private function executeUserACL($group, $manager)
    {
        $modules = $this->getReference('module-name-users');
        $className = $this->container->getParameter('bacon_acl.entities.module_actions_group');

        $actionUsers = [
            'INDEX',
            'NEW',
            'USER_GROUPS',
            'DELETE',
        ];

        foreach ($actionUsers as $action) {
            $actionsGroup = $this->getReference('module-actions-'.$modules->getSlug().'-'.$action);

            $objSave = new $className();
            $objSave->setEnabled(true);
            $objSave->setGroup($group);
            $objSave->setModule($modules);
            $objSave->setModuleActions($actionsGroup);

            $manager->persist($objSave);
        }
    }
}
