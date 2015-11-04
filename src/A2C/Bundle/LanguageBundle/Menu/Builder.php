<?php

namespace A2C\Bundle\LanguageBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function addMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $translate = $this->container->get('translator');

        // Language Menu
        $menu->addChild($translate->trans('Language'));
        $menu[$translate->trans('Language')]->addChild($translate->trans('List'),array('route' => 'admin_language'));
        $menu[$translate->trans('Language')]->addChild($translate->trans('New'),array('route' => 'admin_language_new'));

        return $menu;

    }
}