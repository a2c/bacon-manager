<?php

namespace Bacon\Custom\AclBundle\DataFixtures\ORM;

use Bacon\Bundle\AclBundle\Entity\Module;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadModuleData
 * @package Bacon\Custom\AclBundle\DataFixtures\ORM
 * @author Adan Felipe Medeiros <adan.grg@gmail.com>
 */
class LoadModuleData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $objModule = new Module();
        $objModule
            ->setName('Módulos')
            ->setSlug('module')
        ;

        $manager->persist($objModule);
        $this->addReference('module-name-module', $objModule);

        $objModuleActions = new Module();
        $objModuleActions
            ->setName('Ações dos Módulos')
            ->setSlug('module-actions')
        ;

        $manager->persist($objModuleActions);
        $this->addReference('module-name-module-actions', $objModuleActions);

        $objAcl = new Module();
        $objAcl
            ->setName('ACL')
            ->setSlug('acl')
        ;

        $this->addReference('module-name-acl', $objAcl);
        $manager->persist($objAcl);

        $objUsers = new Module();
        $objUsers
            ->setName('Usuario')
            ->setSlug('users')
        ;

        $this->addReference('module-name-users', $objUsers);
        $manager->persist($objUsers);


        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}
