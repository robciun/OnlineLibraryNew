<?php

/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 10/14/2017
 * Time: 4:47 PM
 */
class BookRepository extends \Doctrine\ORM\EntityRepository
{
    public function getValuesList($bookId)
    {
        return $this->createQueryBuilder('b')
            ->where('b.id = :id')->setParameter('id', $bookId)
            ->orderBy('b.id', 'asc')
            ->getQuery()->getResult();
    }
}