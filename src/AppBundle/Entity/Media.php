<?php

namespace AppBundle\Entity;

/**
 * Media
 */
class Media
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $file_name;


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
     * Set fileName
     *
     * @param string $fileName
     *
     * @return Media
     */
    public function setFileName($fileName)
    {
        $this->file_name = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->file_name;
    }
    /**
     * @var \AppBundle\Entity\Book
     */
    private $contact;


    /**
     * Set contact
     *
     * @param \AppBundle\Entity\Book $contact
     *
     * @return Media
     */
    public function setContact(\AppBundle\Entity\Book $contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \AppBundle\Entity\Book
     */
    public function getContact()
    {
        return $this->contact;
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
     * @return Media
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
}
