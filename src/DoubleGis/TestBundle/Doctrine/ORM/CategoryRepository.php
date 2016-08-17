<?php

namespace DoubleGis\TestBundle\Doctrine\ORM;

use Doctrine\ORM\EntityRepository;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

class CategoryRepository extends NestedTreeRepository
{
    use ResourceRepositoryTrait;
}