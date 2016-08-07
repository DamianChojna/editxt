<?php

/**
 * @author Damian Chojna <damian@designtrends.pl>
 */

namespace Dch\UtilityBundle\Filter;

use Doctrine\ORM\QueryBuilder;

class EqualFilter implements FilterInterface
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param array        $criteria     column name as key, filter value as value, like in \Doctrine\ORM\EntityRepository::findBy()
     *
     * @return void
     */
    public function apply(QueryBuilder $queryBuilder, array $criteria)
    {
        $rootAlias = current($queryBuilder->getRootAliases());

        foreach ($criteria as $field => $value) {
            if (!is_numeric($value) && empty($value)) {
                continue;
            }

            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq(sprintf('%s.%s', $rootAlias, $field), sprintf(':%s', $field)))
                ->setParameter($field, $value);
        }
    }
}
