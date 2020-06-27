<?php

namespace Arguv\CrudApiBundle\Service;

use Doctrine\ORM\EntityManager;

abstract class BaseManager
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var Object
     */
    protected $class;

    /**
     * @param EntityManager $entityManager
     * @param $class
     */
    public function __construct(EntityManager $entityManager, $class)
    {
        $this->entityManager = $entityManager;
        $this->class = $class;
    }

    /**
     * @param $class
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository($class)
    {
        return $this->entityManager->getRepository($class);
    }

    /**
     * @return mixed|Object
     */
    public function createNewEntity()
    {
        return new $this->class;
    }
}

