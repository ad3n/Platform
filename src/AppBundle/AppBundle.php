<?php

namespace Ihsan\AppBundle;

use Ihsan\AppBundle\DependencyInjection\AppExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new AppExtension();
    }
}
