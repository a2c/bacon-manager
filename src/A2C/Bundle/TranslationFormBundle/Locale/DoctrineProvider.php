<?php

namespace A2C\Bundle\TranslationFormBundle\Locale;

use A2lix\TranslationFormBundle\Locale\LocaleProviderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class DoctrineProvider
 * @package A2C\Bundle\TranslationFormBundle\Locale
 *
 * @author Adan Felipe Medeiros<adan.grg@gmail.com>
 * @version 1.0
 */
class DoctrineProvider implements LocaleProviderInterface
{
    const INDEX_PARAMETER_CLASS_LOCALE = 'a2_c_translation_form.locale_provider_class';

    /**
     * @var ContainerInterface
     */
    protected $container;

    protected $repository;

    /**
     * DoctrineProvider constructor.
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
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     */
    protected function getDoctrine()
    {
        return $this->container->get('doctrine');
    }

    /**
     * @return array
     */
    public function getLocales()
    {
        $locales = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository($this->repository)
            ->getAllLocale()
        ;

        $data = [];

        foreach ($locales as $locale) {
            $data[] = $locale->getAcron();
        }

        return $data;
    }

    public function getDefaultLocale() {}

    public function getRequiredLocales()
    {
        return array($this->container->get('request')->getLocale());
    }
}