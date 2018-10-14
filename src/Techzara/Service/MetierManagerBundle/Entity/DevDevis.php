<?php

namespace App\Techzara\Service\MetierManagerBundle\Entity;

use App\Techzara\Service\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * DevDevis
 *
 * @ORM\Table(name="tz_devis")
 * @ORM\Entity
 */
class DevDevis
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
     * @ORM\Column(name="dv_sujet", type="string", length=100, nullable=true)
     */
    private $dvSujet;

    /**
     * @var string
     *
     * @ORM\Column(name="dv_desc", type="text", nullable=true)
     */
    private $dvDesc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dv_date", type="datetime", nullable=true)
     */
    private $dvDate;

    /**
     * @var string
     *
     * @ORM\Column(name="dv_pj", type="string", length=255, nullable=true)
     */
    private $dvPj;

    /**
     * @var DevClient
     *
     * @ORM\ManyToOne(targetEntity="App\Techzara\Service\MetierManagerBundle\Entity\DevClient")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tz_clt_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $lvClient;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Techzara\Service\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tz_usr_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $lvUser;


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
     * @return string
     */
    public function getDvSujet()
    {
        return $this->dvSujet;
    }

    /**
     * @param string $dvSujet
     */
    public function setDvSujet($dvSujet)
    {
        $this->dvSujet = $dvSujet;
    }

    /**
     * @return string
     */
    public function getDvDesc()
    {
        return $this->dvDesc;
    }

    /**
     * @param string $dvDesc
     */
    public function setDvDesc($dvDesc)
    {
        $this->dvDesc = $dvDesc;
    }

    /**
     * @return \DateTime
     */
    public function getDvDate()
    {
        return $this->dvDate;
    }

    /**
     * @param \DateTime $dvDate
     */
    public function setDvDate($dvDate)
    {
        $this->dvDate = $dvDate;
    }

    /**
     * @return string
     */
    public function getDvPj()
    {
        return $this->dvPj;
    }

    /**
     * @param string $dvPj
     */
    public function setDvPj($dvPj)
    {
        $this->dvPj = $dvPj;
    }

    /**
     * @return DevClient
     */
    public function getLvClient()
    {
        return $this->lvClient;
    }

    /**
     * @param DevClient $lvClient
     */
    public function setLvClient($lvClient)
    {
        $this->lvClient = $lvClient;
    }

    /**
     * @return User
     */
    public function getLvUser()
    {
        return $this->lvUser;
    }

    /**
     * @param User $lvUser
     */
    public function setLvUser($lvUser)
    {
        $this->lvUser = $lvUser;
    }
}
