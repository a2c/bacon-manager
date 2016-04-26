<?php

namespace Bacon\Custom\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BaconCustomUserBundle extends Bundle
{
    public function getParent()
    {
        return 'BaconUserBundle';
    }
}
