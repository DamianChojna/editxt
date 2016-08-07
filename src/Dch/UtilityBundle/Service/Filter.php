<?php

/**
 * @author Damian Chojna <damian@designtrends.pl>
 */

namespace Dch\UtilityBundle\Service;

use Doctrine\ORM\QueryBuilder;
use Dch\UtilityBundle\Filter\FilterInterface;
use Dch\UtilityBundle\Service\FilterInterface as FilterServiceInterface;

class Filter implements FilterServiceInterface
{
    /**
     * @var FilterInterface[]
     */
    protected $filters;

    /**
     * @param FilterInterface[] $filters
     */
    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    /**
     * @param array $values
     *
     * @return array
     */
    public function removeEmptyValues(array $values)
    {
        $values = array_filter($values, function ($value) {
            return is_numeric($value) || !empty($value);
        });

        return $values;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $filterClass  filter class name without namespace
     * @param array        $criteria     column name as key, filter value as value, like in \Doctrine\ORM\EntityRepository::findBy()
     *
     * @return $this
     */
    public function apply(QueryBuilder $queryBuilder, $filterClass, array $criteria)
    {
        $this->getFilter($filterClass)
            ->apply($queryBuilder, $criteria);

        return $this;
    }

    /**
     * @param  string                    $filterClass
     * @return FilterInterface
     * @throws \InvalidArgumentException
     */
    protected function getFilter($filterClass)
    {
        foreach ($this->filters as $filter) {
            $supportedFilterClass = get_class($filter);
            if ($filterClass === substr($supportedFilterClass, strrpos($supportedFilterClass, '\\') + 1)) {
                return $filter;
            }
        }

        throw new \InvalidArgumentException(sprintf('You specified wrong filter class. Class %s does not exist or is not supported!', $filterClass));
    }
}
