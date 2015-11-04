<?php

namespace A2C\Bundle\MenuBundle\Twig\Extension;

use Knp\Menu\ItemInterface;
use Knp\Menu\Twig\Helper;
use Knp\Menu\Util\MenuManipulator;
use Knp\Menu\Matcher\MatcherInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Twig_Extension;

class MenuExtension extends Twig_Extension
{

    private $helper;
    private $matcher;
    private $menuManipulator;
    private $container;

    /**
     * @param Helper $helper
     * @param ContainerInterface $container
     */
    public function __construct(Helper $helper, MatcherInterface $matcher = null, MenuManipulator $menuManipulator = null,ContainerInterface $container)
    {
        $this->helper = $helper;
        $this->matcher = $matcher;
        $this->menuManipulator = $menuManipulator;
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('a2c_menu_full_render',array($this,'renderFull'), array('is_safe' => array('html'))),
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'a2c_menu';
    }

    public function renderFull()
    {
        $kernel  = $this->container->get('kernel');
        $bundles = $kernel->getBundles();
        $return  = '';

        foreach ($bundles as $bundle) {

            $bundlePath         =   $bundle->getPath();
            $bundleNamespace    =   $bundle->getNamespace();
            $bundleAlias        =   $bundle->getName();

            if (file_exists($bundlePath . '/Menu/Builder.php')) {
                $classFullName = $bundleNamespace . '\\' . $this->container->getParameter('a2c.name_class.menu');

                if (method_exists($classFullName,$this->container->getParameter('a2c.name_method.menu'))) {
                    $return .= $this->helper->render($bundleAlias .':Builder:'. $this->container->getParameter('a2c.name_method.menu'),array(
                        'firstClass' => 'teste_primeira_classe',
                        'currentClass'  => 'active'
                    ));
                }
            }
        }
        
        return $return;
    }
}