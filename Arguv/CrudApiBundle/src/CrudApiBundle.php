<?php

namespace Arguv\CrudApiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Arguv\CrudApiBundle\DependencyInjection\CrudApiExtentsion;

class CrudApiBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }

    public function getContainerExtension()
    {
        return new CrudApiExtentsion();
    }
}
