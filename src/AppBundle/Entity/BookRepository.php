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

    public function findAllQueryBuilder($filter = '')
    {
        $qb = $this->createQueryBuilder('book');

        if ($filter) {
            $qb->andWhere('book.title LIKE :filter OR book.author LIKE :filter OR book.publisher LIKE :filter OR book.genre LIKE :filter OR book.language LIKE :filter OR book.pages_number LIKE :filter OR book.rating LIKE :filter OR book.isbn LIKE :filter')
                ->setParameter('filter', '%'.$filter.'%');
        }

        return $qb->getQuery()->getResult();
    }
}