<?php

namespace A2C\Bundle\TranslationFormBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LocaleExtension
 * @package A2C\Bundle\TranslationFormBundle\Twig\Extension
 *
 * @author Adan Felipe Medeiros<adan.grg@gmail.com>
 * @version 1.0
 */
class LocaleExtension extends \Twig_Extension
{
    const INDEX_PARAMETER_CLASS_LOCALE = 'a2_c_translation_form.locale_provider_class';

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var string
     */
    protected $repository;


    /**
     * LocaleExtension constructor
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        if (!$container->hasParameter(self::INDEX_PARAMETER_CLASS_LOCALE)) {
            throw new \Exception('Parameter not configured!');
        }

        $this->repository = $container->getParameter(self::INDEX_PARAMETER_CLASS_LOCALE);
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('a2c_locale_convert_name',array($this,'renderNameLocale'), array('is_safe' => array('html'))),
        );
    }

    public function renderNameLocale($locale)
    {
        $languages = $this->container
            ->get('doctrine')
            ->getManager()
            ->getRepository($this->repository)
            ->getAllLocale()
        ;

        $data = [];

        foreach ($languages as $language)
            $data[$language->getAcron()] = $language->getName();

        return array_key_exists($locale,$data) ? $data[$locale] : '';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'a2c_translation_form_locale_extension';
    }
}
