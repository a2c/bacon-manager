<?php

namespace A2C\Bundle\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function addMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $translate = $this->container->get('translator');

        $menu->addChild($translate->trans('Dashboard'),array(
            'route' => 'a2c_dashboard_default_index',
            'childrenAttributes' => array(
                'icon' => 'fa fa-bar-chart'
            )
        ));

        // Users Menu
        $menu->addChild($translate->trans('Users'));
        $menu[$translate->trans('Users')]->addChild($translate->trans('List'),array('route' => 'admin_user'));
        $menu[$translate->trans('Users')]->addChild($translate->trans('New'),array('route' => 'fos_user_registration_register'));

        return $menu;
    }
}