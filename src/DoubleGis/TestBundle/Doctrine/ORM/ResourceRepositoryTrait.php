<?php

namespace DoubleGis\TestBundle\Doctrine\ORM;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;


trait ResourceRepositoryTrait
{

    public function createPaginator()
    {
        $qb = $this->createQueryBuilder($this->getAlias());
        return $this->getPaginator($qb);
    }

    public function createAssociationPaginatorForParentEntity($parentEntityId, $associationField, $associationAlias = 'a', &$qb = null)
    {
        $qb = $this->createQueryBuilder($this->getAlias());
        $qb->leftJoin(sprintf('%s.%s', $this->getAlias(), $associationField), $associationAlias);
        $qb->where(sprintf('%s.id = :%sId', $associationAlias, $associationField));
        $qb->setParameter(sprintf('%sId', $associationField), $parentEntityId);
        return $this->getPaginator($qb);
    }

    public function getPaginator(QueryBuilder $queryBuilder)
    {
        return new Pagerfanta(new DoctrineORMAdapter($queryBuilder));
    }

    /**
     * @return PagerfantaFactory
     */
    protected function getPagerfantaFactory()
    {
        return new PagerfantaFactory('page', 'paginate');
    }

    public function getAlias()
    {
        return 'o';
    }
}