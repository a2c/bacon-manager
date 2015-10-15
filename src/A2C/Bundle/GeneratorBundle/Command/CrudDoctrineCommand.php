<?php

namespace A2C\Bundle\GeneratorBundle\Command;

use Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineCrudCommand;
use Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use A2C\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator as A2CDoctrineCrudGenerator;
use A2C\Bundle\GeneratorBundle\Generator\DoctrineFormGenerator as A2CDoctrineFormGenerator;

class CrudDoctrineCommand extends GenerateDoctrineCrudCommand
{
    private $formGenerator;

    /**
     * @var \Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator
     */
    protected $generator;

    protected function configure()
    {
        parent::configure();

        $this->setName('a2c:generate:crud');
        $this->setDescription('Gerador personalizado pela A2C');
    }

    protected function getSkeletonDirs(BundleInterface $bundle = null)
    {
        $skeletonDirs = array();

        if (isset($bundle) && is_dir($dir = $bundle->getPath().'/Resources/SensioGeneratorBundle/skeleton')) {
            $skeletonDirs[] = $dir;
        }

        if (is_dir($dir = $this->getContainer()->get('kernel')->getRootdir().'/Resources/SensioGeneratorBundle/skeleton')) {
            $skeletonDirs[] = $dir;
        }

        $skeletonDirs[] = realpath(__DIR__.'/../Resources/skeleton');
        $skeletonDirs[] = realpath(__DIR__.'/../Resources');

        return $skeletonDirs;
    }

    protected function createGenerator(BundleInterface $bundle = null)
    {
        return new A2CDoctrineCrudGenerator($this->getContainer()->get('filesystem'));
    }

    protected function getFormGenerator($bundle = null)
    {
        if (null === $this->formGenerator) {
            $this->formGenerator = new A2CDoctrineFormGenerator($this->getContainer()->get('filesystem'));
            $this->formGenerator->setSkeletonDirs($this->getSkeletonDirs($bundle));
        }

        return $this->formGenerator;
    }
}