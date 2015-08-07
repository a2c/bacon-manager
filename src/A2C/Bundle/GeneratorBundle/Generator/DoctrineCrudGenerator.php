<?php

namespace A2C\Bundle\GeneratorBundle\Generator;

use Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator as BaseGenerator;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class DoctrineCrudGenerator extends BaseGenerator
{
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct($filesystem);
    }

    /**
     * Generate the CRUD controller.
     *
     * @param BundleInterface   $bundle           A bundle object
     * @param string            $entity           The entity relative class name
     * @param ClassMetadataInfo $metadata         The entity class metadata
     * @param string            $format           The configuration format (xml, yaml, annotation)
     * @param string            $routePrefix      The route name prefix
     * @param array             $needWriteActions Wether or not to generate write actions
     *
     * @throws \RuntimeException
     */
    public function generate(BundleInterface $bundle, $entity, ClassMetadataInfo $metadata, $format, $routePrefix, $needWriteActions, $forceOverwrite)
    {
        $this->routePrefix = $routePrefix;
        $this->routeNamePrefix = str_replace('/', '_', $routePrefix);
        $this->actions = $needWriteActions ? array('index', 'show', 'new', 'edit', 'delete') : array('index', 'show');

        if (count($metadata->identifier) != 1) {
            throw new \RuntimeException('The CRUD generator does not support entity classes with multiple or no primary keys.');
        }

        $this->entity   = $entity;
        $this->bundle   = $bundle;
        $this->metadata = $metadata;
        $this->setFormat($format);

        $this->generateControllerClass($forceOverwrite);

        $this->generateEntityRepository();

        $dir = sprintf('%s/Resources/views/%s', $this->bundle->getPath(), str_replace('\\', '/', $this->entity));

        if (!file_exists($dir)) {
            $this->filesystem->mkdir($dir, 0777);
        }

        $this->generateIndexView($dir);

        if (in_array('show', $this->actions)) {
            $this->generateShowView($dir);
        }

        if (in_array('new', $this->actions)) {
            $this->generateNewView($dir);
        }

        if (in_array('edit', $this->actions)) {
            $this->generateEditView($dir);
        }

        //$this->generateTestClass();
        $this->generateConfiguration();
    }

    /**
     * Returns an array of record actions to generate (edit, show).
     *
     * @return array
     */
    protected function getRecordActions()
    {
        return array_filter($this->actions, function ($item) {
            return in_array($item, array('show', 'edit','delete'));
        });
    }

    /**
     * Sets the configuration format.
     *
     * @param string $format The configuration format
     */
    private function setFormat($format)
    {
        switch ($format) {
            case 'yml':
            case 'xml':
            case 'php':
            case 'annotation':
                $this->format = $format;
                break;
            default:
                $this->format = 'yml';
                break;
        }
    }

    protected function generateEntityRepository()
    {
        $parts = explode('\\', $this->entity);
        $entityClass = array_pop($parts);
        $entityNamespace = implode('\\', $parts);

        $target = $this->bundle->getPath() . '/Entity/Repository/' . $entityClass . 'Repository.php';

        $this->renderFile('crud/entity/repository.php.twig', $target, array(
            'bundle'            => $this->bundle->getName(),
            'entity'            => $this->entity,
            'entity_class'      => $entityClass,
            'namespace'         => $this->bundle->getNamespace(),
        ));
    }
}