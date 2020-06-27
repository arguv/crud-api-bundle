<?php

namespace Arguv\CrudApiBundle\Controller;

use Arguv\CrudApiBundle\Service\ProductManager;
use Arguv\CrudApiBundle\Repository\ProductRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\EntityRepository;

trait ProductControllerTrait
{
    /**
     * @return mixed|ProductManager
     */
    public function getProductManager()
    {
        return $this->container->get('arguv_crud_api.product.manager');
    }

    /**
     * @return ProductRepository
     */
    public function getEntityRepository()
    {
        return $this->getProductManager()->getRepository("CrudApiBundle:Product");
    }
}