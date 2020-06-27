<?php

namespace Arguv\CrudApiBundle\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityRepository;
use Arguv\CrudApiBundle\Entity\Product;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAllProducts()
    {
        return
            $this
                ->createQueryBuilder('q')
                ->getQuery()
                ->getResult(Query::HYDRATE_ARRAY);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findProduct($id)
    {
        return
            $this
                ->createQueryBuilder('q')
                ->where('q.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getSingleResult(Query::HYDRATE_ARRAY);
    }
}
