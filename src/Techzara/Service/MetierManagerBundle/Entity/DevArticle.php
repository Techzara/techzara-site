<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 10/16/18
 * Time: 10:46 PM
 */

namespace App\Techzara\Service\MetierManagerBundle\Entity;



use Doctrine\ORM\Mapping as ORM;

/**
 * tzArticle
 *
 * @ORM\Table(name="tz_article")
 * @ORM\Entity
 */

class DevArticle
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="art_title", type="string", length=100, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="art_author", type="string", length=100, nullable=true)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="art_photo", type="string", length=255, nullable=true)
     */
    private $artphoto;

    /**
     * @var string
     *
     * @ORM\Column(name="art_content", type="text" , nullable=true)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="art_date", type="datetime", nullable=true)
     */
    private $artDate;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->artDate = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


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
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getArtDate()
    {
        return $this->artDate;
    }

    /**
     * @param string $artDate
     */
    public function setArtDate($artDate)
    {
        $this->artDate = $artDate;
    }

    /**
     * @return string
     */
    public function getArtphoto()
    {
        return $this->artphoto;
    }

    /**
     * @param string $artphoto
     */
    public function setArtphoto($artphoto)
    {
        $this->artphoto = $artphoto;
    }
}