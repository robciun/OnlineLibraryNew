<?php
/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 1/6/2018
 * Time: 7:39 PM
 */

namespace AppBundle\Entity;


class Search
{

    public static $sortChoices = array(
        'publishedAt desc' => 'Publication date : new to old',
        'publishedAt asc' => 'Publication date : old to new',
    );

    protected $sort = 'publishedAt';

    // define the default sort order
    protected $direction = 'desc';

    // a "virtual" property to add a select tag
    protected $sortSelect;

    // the default page number
    protected $page = 1;

    // the default number of items per page
    protected $perPage = 10;

    public function __construct()
    {
        // former code

        $this->initSortSelect();
    }

    public function handleRequest(Request $request)
    {
        $this->setPage($request->get('page', 1));
        $this->setSort($request->get('sort', 'publishedAt'));
        $this->setDirection($request->get('direction', 'desc'));
    }

    public function setPage($page)
    {
        if ($page != null) {
            $this->page = $page;
        }

        return $this;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }

    public function setPerPage($perPage=null)
    {
        if($perPage != null){
            $this->perPage = $perPage;
        }

        return $this;
    }

    public function setSortSelect($sortSelect)
    {
        if ($sortSelect != null) {
            $this->sortSelect =  $sortSelect;
        }
    }

    public function getSortSelect()
    {
        return $this->sort.' '.$this->direction;
    }

    public function initSortSelect()
    {
        $this->sortSelect = $this->sort.' '.$this->direction;
    }

    public function getSort()
    {
        return $this->sort;
    }

    public function setSort($sort)
    {
        if ($sort != null) {
            $this->sort = $sort;
            $this->initSortSelect();
        }

        return $this;
    }

    public function getDirection()
    {
        return $this->direction;
    }

    public function setDirection($direction)
    {
        if ($direction != null) {
            $this->direction = $direction;
            $this->initSortSelect();
        }

        return $this;
    }

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
    private $rating;

    /**
     * @var string
     */
    private $publisher;

    /**
     * @var string
     */
    private $genre;

    /**
     * @var string
     */
    private $book_name;

    /**
     * @var string
     */
    private $ISBN;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return \DateTime
     */
    public function getReleaseYear()
    {
        return $this->release_year;
    }

    /**
     * @param \DateTime $release_year
     */
    public function setReleaseYear($release_year)
    {
        $this->release_year = $release_year;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return int
     */
    public function getPagesNumber()
    {
        return $this->pages_number;
    }

    /**
     * @param int $pages_number
     */
    public function setPagesNumber($pages_number)
    {
        $this->pages_number = $pages_number;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return string
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @param string $publisher
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return string
     */
    public function getBookName()
    {
        return $this->book_name;
    }

    /**
     * @param string $book_name
     */
    public function setBookName($book_name)
    {
        $this->book_name = $book_name;
    }

    /**
     * @return string
     */
    public function getISBN()
    {
        return $this->ISBN;
    }

    /**
     * @param string $ISBN
     */
    public function setISBN($ISBN)
    {
        $this->ISBN = $ISBN;
    }
}