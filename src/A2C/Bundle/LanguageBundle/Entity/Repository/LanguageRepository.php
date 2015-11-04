<?php

namespace A2C\Bundle\LanguageBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use A2C\Bundle\LanguageBundle\Entity\Language;

class LanguageRepository extends EntityRepository
{
    public function getQueryPagination(Language $entity,$sort,$direction)
    {
        $queryBuilder = $this->createQueryBuilder('l');

        $data = array(
            'name' => $entity->getName(),
            'acron' => $entity->getAcron(),
            'locale' => $entity->getLocale(),
            'image' => $entity->getImage(),
            'order_by' => $entity->getOrderBy(),
            'published' => $entity->getPublished(),
            'id' => $entity->getId(),
            'created_at' => $entity->getCreatedAt(),
            'updated_at' => $entity->getUpdatedAt(),
            'deleted_at' => $entity->getDeletedAt(),
        );

        if (!empty($data['name'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->like('l.name', ':name'))
                ->setParameter('name', "%{$data['name']}%")
            ;
        }

        if (!empty($data['acron'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->like('l.acron', ':acron'))
                ->setParameter('acron', "%{$data['acron']}%")
            ;
        }

        if (!empty($data['locale'])) {
        $queryBuilder
                    ->andWhere($queryBuilder->expr()->like('l.locale', ':locale'))
                    ->setParameter('locale', "%{$data['locale']}%")
                ;
        }

        if (!empty($data['image'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->like('l.image', ':image'))
                ->setParameter('image', "%{$data['image']}%")
            ;
        }

        if (!empty($data['order_by'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('l.order_by', ':order_by'))
                ->setParameter('order_by', $data['order_by'])
            ;
        }

        if (!empty($data['published'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('l.published', ':published'))
                ->setParameter('published', $data['published'])
            ;
        }

        if (!empty($data['id'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('l.id', ':id'))
                ->setParameter('id', $data['id'])
            ;
        }

        if (!empty($data['created_at'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('l.created_at', ':created_at'))
                ->setParameter('created_at', $data['created_at'])
            ;
        }

        if (!empty($data['updated_at'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('l.updated_at', ':updated_at'))
                ->setParameter('updated_at', $data['updated_at'])
            ;
        }

        if (!empty($data['deleted_at'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('l.deleted_at', ':deleted_at'))
                ->setParameter('deleted_at', $data['deleted_at'])
            ;
        }

        $queryBuilder->orderBy('l.' . $sort,$direction);

        return $queryBuilder->getQuery();
    }
}