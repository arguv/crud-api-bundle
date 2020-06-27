<?php

namespace Arguv\CrudApiBundle\Service;

use Arguv\CrudApiBundle\Entity\Product;

class ProductManager extends BaseManager
{
    /**
     * @param Product $entity
     * @param $data
     * @param bool|false $insert
     * @return bool
     */
    public function updateEntity(Product $entity, $data, $insert = false)
    {
        foreach ($data as $name => $value) {
            $entity->setName($value['name']);
            $entity->setDescription($value['description']);
        }

        if ($insert === true) {
            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush();

        return true;
    }

    /**
     * @param Product $entity
     * @param $data
     * @return bool
     */
    public function insertEntity(Product $entity, $data)
    {
        $this->updateEntity($entity, $data, true);

        return true;
    }

    /**
     * @param Product $entity
     * @return bool
     */
    public function deleteEntity(Product $entity)
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();

        return true;
    }
}