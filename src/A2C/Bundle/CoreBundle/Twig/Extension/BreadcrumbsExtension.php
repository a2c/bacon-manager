<?php

namespace A2C\Bundle\CoreBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class BreadcrumbsExtension
 * @package A2C\Bundle\CoreBundle\Twig\Extension
 * @author Adan Felipe Medeiros <adan.grg@gmail.com>
 */
class BreadcrumbsExtension extends \Twig_Extension
{
    const TEMPLATE = 'A2CCoreBundle:partial:breadcrumbs.html.twig';

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var \Twig_Environment
     */
    protected $enviroment;

    /**
     * @var array
     */
    protected $parameter = array();

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('a2c_breadcrumbs_render', array($this, 'getRenderView'), array('is_safe' => array('html')))
        ];
    }

    /**
     * @inherited
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->enviroment = $environment;
    }

    /**
     * @return \Twig_Environment
     */
    public function getRenderView()
    {
        $this->enviroment->display(self::TEMPLATE,[
            'itens' => $this->parameter
        ]);
    }

    /**
     * @param $item array
     *
     * @example
     * [
     *    title : 'Home',
     *    route: 'a2c_home',
     *    parameters: [
     *        id: 1
     *    ]
     * ]
     */
    public function addItem($item)
    {
        $this->parameter[] = $item;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'a2c_admin_breadcrumbs';
    }
}
