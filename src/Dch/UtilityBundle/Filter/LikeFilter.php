<?php

/**
 * @author Damian Chojna <damian@designtrends.pl>
 */

namespace Dch\UtilityBundle\Filter;

use Doctrine\ORM\QueryBuilder;

class LikeFilter implements FilterInterface
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
            if (empty($value)) {
                continue;
            }

            $queryBuilder
                ->andWhere($queryBuilder->expr()->like(sprintf('%s.%s', $rootAlias, $field), sprintf(':%s', $field)))
                ->setParameter($field, sprintf('%%%s%%', $value));
        }
    }
}
