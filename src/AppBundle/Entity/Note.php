<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Book;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\NoteRepository")
 * @ORM\Table(name="note")
 * @ORM\HasLifecycleCallbacks()
 * Note
 */
class Note
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Note")
     */
    private $userNote;

    /**
     * @return mixed
     */
    public function getUserNote()
    {
        return $this->userNote;
    }

    /**
     * @param mixed $userNote
     */
    public function setUserNote($userNote)
    {
        $this->userNote = $userNote;
    }

    /**
     * @var string
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="Book", inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     * @var Book
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
     * @param Book $book
     *
     * @return Note
     */
    public function setBook(Book $book = null)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book
     *
     * @return Book
     */
    public function getBook()
    {
        return $this->book;
    }
    /**
     * @var string
     */
    private $username;

    /**
     * @var \DateTime
     */
    private $created;


    /**
     * Set username
     *
     * @param string $username
     *
     * @return Note
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Note
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
    /**
     * @var string
     */
    private $user_email;


    /**
     * Set userEmail
     *
     * @param string $userEmail
     *
     * @return Note
     */
    public function setUserEmail($userEmail)
    {
        $this->user_email = $userEmail;

        return $this;
    }

    /**
     * Get userEmail
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->user_email;
    }
    /**
     * @var \DateTime
     */
    private $date_created;


    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Note
     */
    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }
    /**
     * @var integer
     */
    private $user_id;


    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Note
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }
}
