<?php


namespace Bacon\Custom\AclBundle\Repository;

use Bacon\Bundle\AclBundle\Repository\ModuleActionsGetPagination;
use Bacon\Bundle\AclBundle\Repository\ModuleActionsRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class ModuleActionsRepository
 * @package Bacon\Custom\AclBundle\Repository
 * @author Adan Felipe Medeiros <adan.grg@gmail.com>
 */
class ModuleActionsRepository extends EntityRepository implements ModuleActionsRepositoryInterface
{
    use ModuleActionsGetPagination;
}
