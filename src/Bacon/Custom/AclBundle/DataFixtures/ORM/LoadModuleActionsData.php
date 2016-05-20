<?php

namespace Bacon\Custom\AclBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadModuleActionsData
 * @package Bacon\Custom\AclBundle\DataFixtures\ORM
 * @author Adan Felipe Medeiros <adan.grg@gmail.com>
 */
class LoadModuleActionsData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
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
        $moduleActionsClassName    =   $this->container->getParameter('bacon_acl.entities.module_actions');

        $actionsDefault = [
            'INDEX' => 'Listagem de',
            'NEW' => 'Cadastrar',
            'EDIT' => 'Editar',
            'SHOW' => 'Visualizar',
            'DELETE' => 'Deletar',
        ];

        $moduleSlug = ['module', 'module-actions', 'groups'];

        foreach ($moduleSlug as $moduleName) {
            $module = $this->getReference("module-name-$moduleName");

            foreach ($actionsDefault as $identifier => $action) {
                $moduleActions = new $moduleActionsClassName();
                $moduleActions->setModule($module);
                $moduleActions->setName($action.' '.$module->getName());
                $moduleActions->setIdentifier($identifier);

                $manager->persist($moduleActions);
                $this->addReference('module-actions-'.$module->getSlug().'-'.$identifier, $moduleActions);

                unset($moduleActions);
            }
        }

        $actionUsers = [
            'INDEX' => 'Listagem de',
            'NEW' => 'Cadastrar',
            'USER_GROUPS' => 'Grupos',
            'DELETE' => 'Deletar',
            'SHOW'  => 'Visualizar',
        ];

        $module = $this->getReference('module-name-users');

        foreach ($actionUsers as $identifier => $action) {
            $moduleActions = new $moduleActionsClassName();
            $moduleActions->setModule($module);
            $moduleActions->setName($action.' '.$module->getName());
            $moduleActions->setIdentifier($identifier);

            $manager->persist($moduleActions);
            $this->addReference('module-actions-'.$module->getSlug().'-'.$identifier, $moduleActions);
        }

        // Adicionar ACL
        $module = $this->getReference('module-name-acl');
        $moduleActions = new $moduleActionsClassName();
        $moduleActions->setModule($module);
        $moduleActions->setName('Gerenciamento de'.' '.$module->getName());
        $moduleActions->setIdentifier('ACL');

        $manager->persist($moduleActions);
        $this->addReference('module-actions-'.$module->getSlug().'-'.'ACL', $moduleActions);

        $manager->flush();

        unset($moduleActions);
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}
