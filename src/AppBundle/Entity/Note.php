<?php

namespace AppBundle\Entity;

/**
 * Note
 */
class Note
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $note;

    /**
     * @var \AppBundle\Entity\Book
     */
    private $book;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Note
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set book
     *
     * @param \AppBundle\Entity\Book $book
     *
     * @return Note
     */
    public function setBook(\AppBundle\Entity\Book $book = null)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book
     *
     * @return \AppBundle\Entity\Book
     */
    public function getBook()
    {
        return $this->book;
    }
}

