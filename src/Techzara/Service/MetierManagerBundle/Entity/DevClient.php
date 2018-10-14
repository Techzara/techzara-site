<?php

namespace App\Techzara\Service\MetierManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DevClient
 *
 * @ORM\Table(name="tz_client")
 * @ORM\Entity
 */
class DevClient
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
     * @ORM\Column(name="clt_name", type="string", length=100, nullable=true)
     */
    private $cltName;

    /**
     * @var string
     *
     * @ORM\Column(name="clt_firstname", type="string", length=100, nullable=true)
     */
    private $cltFirstname;

    /**
     * @var string
     *
     * @ORM\Column(name="clt_address", type="string", length=255, nullable=true)
     */
    private $cltAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="clt_tel", type="string", length=45, nullable=true)
     */
    private $cltTel;

    /**
     * @var string
     *
     * @ORM\Column(name="clt_mdp", type="string", length=255, nullable=true)
     */
    private $cltMdp;

    /**
     * @var boolean
     *
     * @ORM\Column(name="clt_is_valid", type="boolean")
     */
    private $cltIsValid = false;

    /**
     * @var string
     *
     * @ORM\Column(name="clt_nom_entreprise", type="string", length=100, nullable=true)
     */
    private $cltNomEntreprise;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="clt_last_connected", type="datetime", nullable=true)
     */
    private $cltLastConnected;


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
    public function getCltName()
    {
        return $this->cltName;
    }

    /**
     * @param string $cltName
     */
    public function setCltName($cltName)
    {
        $this->cltName = $cltName;
    }

    /**
     * @return string
     */
    public function getCltFirstname()
    {
        return $this->cltFirstname;
    }

    /**
     * @param string $cltFirstname
     */
    public function setCltFirstname($cltFirstname)
    {
        $this->cltFirstname = $cltFirstname;
    }

    /**
     * @return string
     */
    public function getCltAddress()
    {
        return $this->cltAddress;
    }

    /**
     * @param string $cltAddress
     */
    public function setCltAddress($cltAddress)
    {
        $this->cltAddress = $cltAddress;
    }

    /**
     * @return string
     */
    public function getCltTel()
    {
        return $this->cltTel;
    }

    /**
     * @param string $cltTel
     */
    public function setCltTel($cltTel)
    {
        $this->cltTel = $cltTel;
    }

    /**
     * @return string
     */
    public function getCltMdp()
    {
        return $this->cltMdp;
    }

    /**
     * @param string $cltMdp
     */
    public function setCltMdp($cltMdp)
    {
        $this->cltMdp = $cltMdp;
    }

    /**
     * @return string
     */
    public function getCltIsValid()
    {
        return $this->cltIsValid;
    }

    /**
     * @param string $cltIsValid
     */
    public function setCltIsValid($cltIsValid)
    {
        $this->cltIsValid = $cltIsValid;
    }

    /**
     * @return string
     */
    public function getCltNomEntreprise()
    {
        return $this->cltNomEntreprise;
    }

    /**
     * @param string $cltNomEntreprise
     */
    public function setCltNomEntreprise($cltNomEntreprise)
    {
        $this->cltNomEntreprise = $cltNomEntreprise;
    }

    /**
     * @return string
     */
    public function getCltLastConnected()
    {
        return $this->cltLastConnected;
    }

    /**
     * @param string $cltLastConnected
     */
    public function setCltLastConnected($cltLastConnected)
    {
        $this->cltLastConnected = $cltLastConnected;
    }
}
