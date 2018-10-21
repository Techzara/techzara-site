<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 10/19/18
 * Time: 11:06 PM
 */

namespace App\Techzara\Service\MetierManagerBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
/**
 * tzProgramme
 *
 * @ORM\Table(name="tz_programme")
 * @ORM\Entity
 */

class TzProgramme
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
     * @ORM\Column(name="tz_programme_title", type="string", length=100, nullable=true)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="tz_programme_desc",type="text" , nullable=true)
     */
    private $tz_programme_description;

    /**
     * @var string
     * @ORM\Column(name="tz_programme_photo",type="string" ,length=150 , nullable=true)
     */
    private $tz_programme_photo;

    /**
     * @var string
     * @ORM\Column(name="tz_programme_intervenants",type="string",length=150,nullable=true)
     */
    private $tz_programme_intervenants;

    /**
     * @var string
     * @ORM\Column(name="tz_programme_lieu",type="string",length=150,nullable=true)
     */
    private $tz_programme_lieu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="tz_programme_date_debut", type="datetime", nullable=true)
     */
    private $tz_programme_date_debut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="tz_programme_date_fin", type="datetime", nullable=true)
     */
    private $tz_programme_date_fin;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function getTzProgrammeDescription()
    {
        return $this->tz_programme_description;
    }

    /**
     * @param string $tz_programme_description
     */
    public function setTzProgrammeDescription($tz_programme_description)
    {
        $this->tz_programme_description = $tz_programme_description;
    }

    /**
     * @return string
     */
    public function getTzProgrammePhoto()
    {
        return $this->tz_programme_photo;
    }

    /**
     * @param string $tz_programme_photo
     */
    public function setTzProgrammePhoto( $tz_programme_photo)
    {
        $this->tz_programme_photo = $tz_programme_photo;
    }

    /**
     * @return string
     */
    public function getTzProgrammeIntervenants()
    {
        return $this->tz_programme_intervenants;
    }

    /**
     * @param string $tz_programme_intervenants
     */
    public function setTzProgrammeIntervenants($tz_programme_intervenants)
    {
        $this->tz_programme_intervenants = $tz_programme_intervenants;
    }

    /**
     * @return \DateTime
     */
    public function getTzProgrammeDateDebut()
    {
        return $this->tz_programme_date_debut;
    }

    /**
     * @param \DateTime $tz_programme_date_debut
     */
    public function setTzProgrammeDateDebut($tz_programme_date_debut)
    {
        $this->tz_programme_date_debut = $tz_programme_date_debut;
    }

    /**
     * @return \DateTime
     */
    public function getTzProgrammeDateFin()
    {
        return $this->tz_programme_date_fin;
    }

    /**
     * @param \DateTime $tz_programme_date_fin
     */
    public function setTzProgrammeDateFin($tz_programme_date_fin)
    {
        $this->tz_programme_date_fin = $tz_programme_date_fin;
    }

    /**
     * @return string
     */
    public function getTzProgrammeLieu()
    {
        return $this->tz_programme_lieu;
    }

    /**
     * @param string $tz_programme_lieu
     */
    public function setTzProgrammeLieu( $tz_programme_lieu)
    {
        $this->tz_programme_lieu = $tz_programme_lieu;
    }


}