<?php
/**
 * @author Damian Chojna <damian@designtrends.pl>
 */

namespace Editxt\ContentBundle\Service;

use Dch\UtilityBundle\Service\FilterInterface;
use Doctrine\ORM\QueryBuilder;
use Editxt\ContentBundle\Repository\ContentRepository;
use Knp\Component\Pager\PaginatorInterface;

class ContentProvider {

    /**
     * @var ContentRepository
     */
    protected $contentRepository;

    /**
     * @var FilterInterface
     */
    protected $filterManager;

    /**
     * @var PaginatorInterface
     */
    protected $paginator;

    /**
     * @var int
     */
    protected $defaultLimit;


    /**
     * @param ContentRepository $contentRepository
     * @param FilterInterface $filterManager
     * @param PaginatorInterface $paginator
     * @param int $defaultLimit
     */
    public function __construct(
        ContentRepository $contentRepository,
        FilterInterface $filterManager,
        PaginatorInterface $paginator,
        $defaultLimit
    )
    {
        $this->contentRepository = $contentRepository;
        $this->filterManager = $filterManager;
        $this->paginator = $paginator;
        $this->defaultLimit = $defaultLimit;
    }

    /**
     * @param array $filters
     * @param null $page
     * @param null $limit
     *
     * @return PaginationInterface
     */
    public function getContentList(array $filters, $page = null, $limit = null)
    {
        $queryBuilder = $this->contentRepository->getListQueryBuilder();
        $this->applyFilters($queryBuilder, $filters);
        $pagination = $this->createPagination($queryBuilder, $page, $limit);

        return $pagination;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param array        $filters
     */
    protected function applyFilters(QueryBuilder $queryBuilder, array $filters)
    {
        $nonEmptyFilters = $this->filterManager->removeEmptyValues($filters);

        $filtersMap = array(
            'title'           => 'LikeFilter',
        );

        foreach (array_intersect_key($nonEmptyFilters, $filtersMap) as $fieldName => $filter) {
            $this->filterManager->apply($queryBuilder, $filtersMap[$fieldName], array($fieldName => $filter));
        }

    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param int          $page
     * @param int          $limit
     *
     * @return PaginationInterface
     */
    protected function createPagination(QueryBuilder $queryBuilder, $page, $limit)
    {
        return $this->paginator->paginate(
            $queryBuilder->getQuery(),
            $page ? $page : 1,
            $limit ? $limit : $this->defaultLimit
        );
    }
}
