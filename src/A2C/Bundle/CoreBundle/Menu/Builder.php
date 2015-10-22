<?php

namespace A2C\Bundle\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function addMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home',array('route' => 'a2c_dashboard_default_index'));

        $menu->addChild('Teste');
        $menu['Teste']->addChild('Teste 123',array('route' => ''));

        return $menu;
    }
}