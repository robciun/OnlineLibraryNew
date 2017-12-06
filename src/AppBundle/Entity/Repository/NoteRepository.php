<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 11/29/2017
 * Time: 11:05 AM
 */
class NoteRepository extends EntityRepository
{
    public function getValuesList($noteId)
    {
        return $this->createQueryBuilder('n')
            ->join('n.book', 'b')
            ->where('b.id = :id')->setParameter('id', $noteId)
            ->orderBy('b.id', 'asc')
            ->getQuery()
            ->getArrayResult();
    }
}