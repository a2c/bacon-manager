<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            //Core Bundle
            new Bacon\Bundle\CoreBundle\BaconCoreBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Bacon\Bundle\LanguageBundle\BaconLanguageBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Bacon\Bundle\MenuBundle\BaconMenuBundle(),

            //Security
            new FOS\UserBundle\FOSUserBundle(),
            new Bacon\Bundle\UserBundle\BaconUserBundle(),
            new Bacon\Bundle\AclBundle\BaconAclBundle(),

            // ApiKey
            new Uecode\Bundle\ApiKeyBundle\UecodeApiKeyBundle(),

            // Fixtures
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),

            //MediaLibrary
            new Oneup\UploaderBundle\OneupUploaderBundle(),
            new Bacon\Bundle\MediaLibraryBundle\BaconMediaLibraryBundle(),
            new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),

            //Aplication
            new AppBundle\AppBundle(),
            new Bacon\Custom\UserBundle\BaconCustomUserBundle(),
            new Bacon\Custom\AclBundle\BaconCustomAclBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Bacon\Bundle\GeneratorBundle\BaconGeneratorBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__) . '/var/cache/' . $this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__) . '/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }

}
