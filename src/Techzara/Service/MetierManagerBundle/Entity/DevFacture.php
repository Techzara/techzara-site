<?php

namespace App\Techzara\Service\MetierManagerBundle\Entity;

use App\Techzara\Service\MetierManagerBundle\Utils\EtatFactureName;
use Doctrine\ORM\Mapping as ORM;

/**
 * DevRole
 *
 * @ORM\Table(name="tz_facture")
 * @ORM\Entity
 */
class DevFacture
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
     * @var \DateTime
     *
     * @ORM\Column(name="fct_date", type="datetime", nullable=true)
     */
    private $fctDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="fct_status", type="smallint", nullable=true)
     */
    private $fctStatus;

    /**
     * @var DevServiceClient
     *
     * @ORM\ManyToOne(targetEntity="App\Techzara\Service\MetierManagerBundle\Entity\DevServiceClient")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tz_srv_clt_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $lvServiceClient;


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
     * @return \DateTime
     */
    public function getFctDate()
    {
        return $this->fctDate;
    }

    /**
     * @param \DateTime $fctDate
     */
    public function setFctDate($fctDate)
    {
        $this->fctDate = $fctDate;
    }

    /**
     * @return int
     */
    public function getFctStatus()
    {
        return $this->fctStatus;
    }

    /**
     * @param int $fctStatus
     */
    public function setFctStatus($fctStatus)
    {
        $this->fctStatus = $fctStatus;
    }

    /**
     * @return DevServiceClient
     */
    public function getLvServiceClient()
    {
        return $this->lvServiceClient;
    }

    /**
     * @param DevServiceClient $lvServiceClient
     */
    public function setLvServiceClient($lvServiceClient)
    {
        $this->lvServiceClient = $lvServiceClient;
    }

    /**
     * @return string
     */
    public function getStatusString()
    {
        return EtatFactureName::$VALEUR_TYPE[$this->fctStatus];
    }
}
