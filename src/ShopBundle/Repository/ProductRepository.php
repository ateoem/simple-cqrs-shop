<?php

namespace ShopBundle\Repository;

class ProductRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return \Doctrine\ORM\Query
     */
    public function getPaginationQuery()
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->orderBy('p.createdAt', 'ASC')
            ->getQuery();
    }
}
