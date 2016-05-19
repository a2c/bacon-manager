<?php

namespace Bacon\Custom\AclBundle\Repository;

use Bacon\Bundle\AclBundle\Repository\ModuleActionsGroupInterface as ModuleActionsGroupRepositoryInterface;
use Doctrine\ORM\EntityRepository;
use Bacon\Bundle\AclBundle\Repository\HasAuthorationRepository;

/**
 * Class ModuleActionsGroupRepository
 * @package Bacon\Custom\AclBundle\Repository
 * @author Adan Felipe Medeiros <adan.grg@gmail.com>
 */
class ModuleActionsGroupRepository extends EntityRepository implements ModuleActionsGroupRepositoryInterface
{
    use HasAuthorationRepository;
}
