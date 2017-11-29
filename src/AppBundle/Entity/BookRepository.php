<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 10/14/2017
 * Time: 4:47 PM
 */

class BookRepository extends EntityRepository
{
    public function getValuesList($bookId)
    {
        return $this->createQueryBuilder('b')
            ->where('b.id = :id')->setParameter('id', $bookId)
            ->orderBy('b.id', 'asc')
            ->getQuery()->getArrayResult();
    }
}