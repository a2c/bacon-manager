<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class Builder
 * @package AppBundle\Menu
 * @author Adan Felipe Medeiros <adan.grg@gmail.com>
 * @version 1.0
 */
class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param FactoryInterface $factory
     * @param array            $options
     *
     * @return mixed
     */
    public function addMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $translate = $this->container->get('translator');

        //User
        $menu->addChild($translate->trans('User'), ['route' => 'admin_user'])->setAttribute('icon', '<i class="fa fa-user"></i>');

        //Groups
        $menu->addChild($translate->trans('Group of Users'), ['route' => 'fos_user_group_list'])->setAttribute('icon', '<i class="fa fa-users"></i>');

        $menu->addChild($translate->trans('ACL'))->setAttribute('icon', '<i class="fa fa-lock"></i>');
        $menu[$translate->trans('ACL')]->addChild($translate->trans('Module'), ['route' => 'module']);
        $menu[$translate->trans('ACL')]->addChild($translate->trans('Module Actions'), ['route' => 'module_actions']);

        return $menu;
    }
}
