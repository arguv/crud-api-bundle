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
        $data = $this->normalizeProductData($data);

        $entity->setName($data['name']);
        $entity->setDescription($data['description']);

        if ($insert === true) {
            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush();

        return true;
    }

    /**
     * Normalize and validate the request payload for one product.
     *
     * The public API documents a one-item JSON array, but accepting a single
     * object as well makes the manager safer to use outside the controller.
     * Multiple products are rejected because this method updates one entity.
     *
     * @param mixed $data
     * @return array
     * @throws \InvalidArgumentException
     */
    private function normalizeProductData($data)
    {
        if (!is_array($data)) {
            throw new \InvalidArgumentException('Product data must be a JSON object or a one-item array.');
        }

        if (array_key_exists('name', $data) || array_key_exists('description', $data)) {
            $productData = $data;
        } elseif (count($data) === 1 && isset($data[0]) && is_array($data[0])) {
            $productData = $data[0];
        } else {
            throw new \InvalidArgumentException('Product data must contain exactly one product.');
        }

        if (!array_key_exists('name', $productData) || !array_key_exists('description', $productData)) {
            throw new \InvalidArgumentException('Product name and description are required.');
        }

        if (!is_string($productData['name']) || !is_string($productData['description'])) {
            throw new \InvalidArgumentException('Product name and description must be strings.');
        }

        $name = trim($productData['name']);
        $description = trim($productData['description']);

        if ($name === '' || $description === '') {
            throw new \InvalidArgumentException('Product name and description cannot be empty.');
        }

        if (strlen($name) > 100) {
            throw new \InvalidArgumentException('Product name cannot exceed 100 characters.');
        }

        return array(
            'name' => $name,
            'description' => $description,
        );
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
