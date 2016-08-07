<?php
/**
 * @author Damian Chojna <damian@designtrends.pl>
 */

namespace Editxt\ContentBundle\Service;

use Dch\UtilityBundle\Service\FilterInterface;
use Doctrine\ORM\QueryBuilder;
use Editxt\ContentBundle\Repository\ContentItemRepository;
use Knp\Component\Pager\PaginatorInterface;

class ContentItemProvider {

    /**
     * @var ContentItemRepository
     */
    protected $repository;

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
     * @param ContentItemRepository $repository
     * @param FilterInterface $filterManager
     * @param PaginatorInterface $paginator
     * @param int $defaultLimit
     */
    public function __construct(
        ContentItemRepository $repository,
        FilterInterface $filterManager,
        PaginatorInterface $paginator,
        $defaultLimit
    )
    {
        $this->repository = $repository;
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
    public function getContentItemList(array $filters, $page = null, $limit = null)
    {
        $queryBuilder = $this->repository->getListQueryBuilder();
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

        if(isset($nonEmptyFilters['tags']) && $tag = $nonEmptyFilters['tags']) {
            $queryBuilder->orWhere("tag.id = :tagId")
                ->setParameter('tagId', $tag->getId());
        }
        if(isset($nonEmptyFilters['subTitles']) && $subTitle = $nonEmptyFilters['subTitles']) {
            $queryBuilder->orWhere("subtit.id = :subTitleId")
                ->setParameter('subTitleId', $subTitle->getId());
        }

        $filtersMap = array(
            'body'           => 'LikeFilter',
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
