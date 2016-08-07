<?php

namespace Dch\UtilityBundle\Filter;

use Doctrine\ORM\QueryBuilder;
use Dch\UtilityBundle\Exception\InvalidFilterDataException;

interface FilterInterface
{
    /**
     * @param  QueryBuilder               $queryBuilder
     * @param  array                      $criteria     column name as key, filter value as value, like in \Doctrine\ORM\EntityRepository::findBy()
     * @return void
     * @throws InvalidFilterDataException
     */
    public function apply(QueryBuilder $queryBuilder, array $criteria);
}
