<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Book
 */
class Book
{

//    /**
//     * @ORM\Column(type="string")
//     *
//     * @Assert\NotBlank(message="Please, upload the book as a PDF file.")
//     * @Assert\File(mimeTypes={ "application/pdf" })
//     */
//    private $upload_book;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $author;

    /**
     * @var \DateTime
     */
    private $release_year;

    /**
     * @var string
     */
    private $language;

    /**
     * @var integer
     */
    private $pages_number;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $comments_count;

    /**
     * @var integer
     */
    private $rating;

    /**
     * @var integer
     */
    private $readers_count;

    /**
     * @var integer
     */
    private $last_read_page;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Note", mappedBy="book")
     * @ORM\OrderBy({"created" = "DESC"})
     */
    private $notes;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }
//    public function getUploadBook()
//    {
//        return $this->upload_book;
//    }
//
//    public function setUploadBook($uploadBook)
//    {
//        $this->upload_book = $uploadBook;
//
//        return $this;
//    }

    /**
     * @return ArrayCollection|Note[]
     */
    public function getNotes()
    {
        return $this->notes;
    }


    /**
     * Set title
     *
     * @param string $title
     *
     * @return Book
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Book
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set releaseYear
     *
     * @param \DateTime $releaseYear
     *
     * @return Book
     */
    public function setReleaseYear($releaseYear)
    {
        $this->release_year = $releaseYear;

        return $this;
    }

    /**
     * Get releaseYear
     *
     * @return \DateTime
     */
    public function getReleaseYear()
    {
        return $this->release_year;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return Book
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set pagesNumber
     *
     * @param integer $pagesNumber
     *
     * @return Book
     */
    public function setPagesNumber($pagesNumber)
    {
        $this->pages_number = $pagesNumber;

        return $this;
    }

    /**
     * Get pagesNumber
     *
     * @return integer
     */
    public function getPagesNumber()
    {
        return $this->pages_number;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Book
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set commentsCount
     *
     * @param integer $commentsCount
     *
     * @return Book
     */
    public function setCommentsCount($commentsCount)
    {
        $this->comments_count = $commentsCount;

        return $this;
    }

    /**
     * Get commentsCount
     *
     * @return integer
     */
    public function getCommentsCount()
    {
        return $this->comments_count;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     *
     * @return Book
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set readersCount
     *
     * @param integer $readersCount
     *
     * @return Book
     */
    public function setReadersCount($readersCount)
    {
        $this->readers_count = $readersCount;

        return $this;
    }

    /**
     * Get readersCount
     *
     * @return integer
     */
    public function getReadersCount()
    {
        return $this->readers_count;
    }

    /**
     * Set lastReadPage
     *
     * @param integer $lastReadPage
     *
     * @return Book
     */
    public function setLastReadPage($lastReadPage)
    {
        $this->last_read_page = $lastReadPage;

        return $this;
    }

    /**
     * Get lastReadPage
     *
     * @return integer
     */
    public function getLastReadPage()
    {
        return $this->last_read_page;
    }
    /**
     * @var string
     */
    private $publisher;

    /**
     * @var string
     */
    private $genre;


    /**
     * Set publisher
     *
     * @param string $publisher
     *
     * @return Book
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * Get publisher
     *
     * @return string
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * Set genre
     *
     * @param string $genre
     *
     * @return Book
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }
    private $user_email;


    /**
     * Set userEmail
     *
     * @param string $userEmail
     *
     * @return Book
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
     * @return Book
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
     * @var \AppBundle\Entity\Media
     */
    private $contact;


    /**
     * Set contact
     *
     * @param \AppBundle\Entity\Media $contact
     *
     * @return Book
     */
    public function setContact(\AppBundle\Entity\Media $contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \AppBundle\Entity\Media
     */
    public function getContact()
    {
        return $this->contact;
    }
    /**
     * @var string
     */
    private $book_name;


    /**
     * Set bookName
     *
     * @param string $bookName
     *
     * @return Book
     */
    public function setBookName($bookName)
    {
        $this->book_name = $bookName;

        return $this;
    }

    /**
     * Get bookName
     *
     * @return string
     */
    public function getBookName()
    {
        return $this->book_name;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $note;


    /**
     * Add note
     *
     * @param \AppBundle\Entity\Note $note
     *
     * @return Book
     */
    public function addNote(\AppBundle\Entity\Note $note)
    {
        $this->note[] = $note;

        return $this;
    }

    /**
     * Remove note
     *
     * @param \AppBundle\Entity\Note $note
     */
    public function removeNote(\AppBundle\Entity\Note $note)
    {
        $this->note->removeElement($note);
    }

    /**
     * Get note
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNote()
    {
        return $this->note;
    }
    /**
     * @var string
     */
    private $isbn;



    /**
     * Set isbn
     *
     * @param string $isbn
     *
     * @return Book
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn
     *
     * @return string
     */
    public function getIsbn()
    {
        return $this->isbn;
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
     * @return Book
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
