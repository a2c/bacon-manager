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
        $acl  = $this->container->get('bacon_acl.service.authorization');




        $translate = $this->container->get('translator');

        //User
        if ($acl->authorize('users', 'INDEX')) {
            $menu->addChild($translate->trans('User'), ['route' => 'admin_user'])->setAttribute('icon', '<i class="fa fa-user"></i>');
        }
        //Groups
        if ($acl->authorize('groups', 'INDEX')) {
            $menu->addChild($translate->trans('Group of Users'), ['route' => 'fos_user_group_list'])->setAttribute('icon', '<i class="fa fa-users"></i>');
        }

        if ($acl->authorize('acl', 'ACL')) {
            $menu->addChild($translate->trans('ACL'))->setAttribute('icon', '<i class="fa fa-lock"></i>');
        }

        if ($acl->authorize('module', 'INDEX')) {
            if (isset($menu[$translate->trans('ACL')])) {
                $menu[$translate->trans('ACL')]->addChild($translate->trans('Module'), ['route' => 'module']);
            }
        }

        if ($acl->authorize('module-actions', 'INDEX')) {
            if (isset($menu[$translate->trans('ACL')])) {
                $menu[$translate->trans('ACL')]->addChild($translate->trans('Module Actions'), ['route' => 'module_actions']);
            }
        }

        return $menu;
    }
}
