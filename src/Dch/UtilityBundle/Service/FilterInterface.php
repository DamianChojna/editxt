<?php

/**
 * @author Damian Chojna <damian@designtrends.pl>
 */

namespace Dch\UtilityBundle\Service;

use Doctrine\ORM\QueryBuilder;

interface FilterInterface
{
    /**
     * @param FilterInterface[] $filters
     */
    public function __construct(array $filters);

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $filterClass  filter class name without namespace
     * @param array        $criteria     column name as key, filter value as value, like in \Doctrine\ORM\EntityRepository::findBy()
     *
     * @return $this
     */
    public function apply(QueryBuilder $queryBuilder, $filterClass, array $criteria);

    /**
     * @param array $values
     *
     * @return array
     */
    public function removeEmptyValues(array $values);
}
