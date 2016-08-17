<?php

namespace DoubleGis\TestBundle\Doctrine\ORM;

use Doctrine\ORM\EntityRepository;

class BuildingRepository extends EntityRepository
{
    use ResourceRepositoryTrait;
}