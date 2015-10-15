<?php

namespace A2C\Bundle\CoreBundle\Filter;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

/**
 * Class SoftDeleteableFilter
 *
 * @package A2C\Bundle\CoreBundle\Filter
 * @author Adan Felipe Medeiros
 * @version 1.0
 */
class SoftDeleteableFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        return $targetTableAlias. '.deleted_at is null';
    }

}