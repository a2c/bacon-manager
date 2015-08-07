<?php

namespace A2C\Bundle\GeneratorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Console\Application;
use Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator;
use Symfony\Component\Filesystem\FileSystem as LoadFileSystem;

class A2CGeneratorBundle extends Bundle
{
    public function getParent()
    {
        return 'SensioGeneratorBundle';
    }

}
