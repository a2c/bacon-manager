<?php

namespace A2C\Bundle\LanguageBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use \Twig_Extension;

class LanguageExtension extends Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function renderMenuLanguages()
    {
        $router             =   $this->getContainer()->get('router');
        $request             =   $this->getContainer()->get('request');

        $languages          =   $this->getDoctrine()->getRepository('A2CLanguageBundle:Language')->findAll();

        $htmlReturn = '';
        foreach ($languages as $lang) {
            $routerParamters['_locale'] = $lang->getAcron();
            $htmlReturn .= '<li><a href="' . $router->generate('locale_change', [ 'current' => $request->getLocale(), 'locale' => $lang->getAcron()]) . '"><span class="flag-icon flag-icon-'. $this->getAcronByLocale($lang->getLocale()) .'"></span>&nbsp;&nbsp;&nbsp;'. $lang->getName() .'</a></li>';
        }

        return $htmlReturn;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('a2c_menu_language_render', array($this, 'renderMenuLanguages'), array('is_safe' => array('html')))
        ];
    }

    /**
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     */
    public function getDoctrine()
    {
        return $this->container->get('doctrine');
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'a2c_languge_extension';
    }

    private function getAcronByLocale($locale)
    {
        $country = explode('_', $locale);
        return strtolower($country[1]);
    }

}