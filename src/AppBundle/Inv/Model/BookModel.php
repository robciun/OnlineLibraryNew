<?php

/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 9/23/2017
 * Time: 5:18 PM
 */
namespace AppBundle\Inv\Model;

use AppBundle\Entity\Book;
use AppBundle\Form\Type\BookType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
class BookModel
{
    protected $entityName = 'book';
    protected $entityClass = Book::class;

    public function getEntityRecord()
    {
        return new Book();
    }

    public function getEntityFormType()
    {
        return new BookType($this->em);
    }

    public function postRemove($record, $options = [])
    {
        /* @var $record Book */
//        $book = $record->getBook();
//        $this->em->getRepository('Book')->recalcTotalAmounts($book);

    }

    public function postNewEntitySave($entity, Request $request, $formData)
    {
        /* @var $entity Book */
//        $book = $entity->getBook();
//        $this->em->getRepository('Book')->recalcTotalAmounts($book);
    }

    public function postUpdate($record, Form $form = null)
    {
        /* @var $entity Book */
//        $book = $entity->getBook();
//        $this->em->getRepository('Book')->recalcTotalAmounts($book);
    }

    /**
     * @param $entity
     * @param Form|null $form
     */
    public function preNewEntitySave($entity, Form $form = null)
    {

    }

    public function preEntityUpdate($entity, Form $form = null)
    {

    }

    /**
     * @param $string
     * @return float
     */
    public function fixNumberWithComma($string)
    {
        if (strpos($string, ',')) {
            $value = str_replace(',', '.', $string);
            return floatval($value);
        }
        return $string;
    }

    public function setFormOptions(Request $request, $entity)
    {
//        $options = [];
//        $this->updateOptionsSetCurrency($options);
//        return $options;
    }

    public function setModalFormOptions(Request $request, $entity)
    {
//        $options = [];
//        $this->updateOptionsSetCurrency($options);
//        return $options;
    }
}