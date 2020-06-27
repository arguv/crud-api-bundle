<?php

namespace Arguv\CrudApiBundle\Service;

use Doctrine\ORM\EntityRepository;

interface BaseInterface
{
    /**
     * @return EntityRepository
     */
    public function getEntityRepository();
}
