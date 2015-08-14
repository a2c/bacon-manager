<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Post;

class PostRepository extends EntityRepository
{
    public function getQueryPagination(Post $post)
    {
        $queryBuilder = $this->createQueryBuilder('p');
        $queryBuilder->orderBy('p.id');

        return $queryBuilder->getQuery();
    }
}