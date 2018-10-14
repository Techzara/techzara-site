<?php

namespace App\Techzara\Service\MetierManagerBundle\Entity;

use App\Techzara\Service\MetierManagerBundle\Form\DevServiceTypeType;
use App\Techzara\Service\MetierManagerBundle\Utils\ValeurTypeName;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * DevService
 *
 * @ORM\Table(name="tz_service_option")
 * @UniqueEntity(fields="srvOptLabel", message="Nom déjà pris")
 * @ORM\Entity
 */
class DevServiceOption
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
     * @ORM\Column(name="srv_opt_label", type="string", length=255, nullable=true)
     */
    private $srvOptLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="srv_opt_desc", type="text", nullable=true)
     */
    private $srvOptDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="srv_opt_type", type="string", length=45, nullable=true)
     */
    private $srvOptType;

    /**
     * @var float
     *
     * @ORM\Column(name="srv_opt_valeur", type="float", nullable=true)
     */
    private $srvOptValeur;

    /**
     * @var DevServiceOptionType
     *
     * @ORM\ManyToOne(targetEntity="App\Techzara\Service\MetierManagerBundle\Entity\DevServiceOptionType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tz_srv_opt_tp_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $lvServiceOptionType;

    /**
     * @var DevServiceOptionValeurType
     *
     * @ORM\OneToOne(targetEntity="App\Techzara\Service\MetierManagerBundle\Entity\DevServiceOptionValeurType",
     *     cascade={"persist"})
     * @ORM\JoinColumn(name="tz_srv_opt_val_tp_id", referencedColumnName="id")
     */
    private $lvServiceOptionValeurType;

    /**
     * @ORM\ManyToMany(targetEntity="App\Techzara\Service\MetierManagerBundle\Entity\DevService", mappedBy="lvServiceOptions", cascade={"persist"})
     */
    private $lvServices;

    /**
     * @ORM\ManyToMany(targetEntity="App\Techzara\Service\MetierManagerBundle\Entity\DevServiceClient", mappedBy="lvServiceOptions", cascade={"persist"})
     */
    private $lvServiceClients;


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
    public function getSrvOptLabel()
    {
        return $this->srvOptLabel;
    }

    /**
     * @param string $srvOptLabel
     */
    public function setSrvOptLabel($srvOptLabel)
    {
        $this->srvOptLabel = $srvOptLabel;
    }

    /**
     * @return string
     */
    public function getSrvOptDesc()
    {
        return $this->srvOptDesc;
    }

    /**
     * @param string $srvOptDesc
     */
    public function setSrvOptDesc($srvOptDesc)
    {
        $this->srvOptDesc = $srvOptDesc;
    }

    /**
     * @return string
     */
    public function getSrvOptType()
    {
        return $this->srvOptType;
    }

    /**
     * @param string $srvOptType
     */
    public function setSrvOptType($srvOptType)
    {
        $this->srvOptType = $srvOptType;
    }

    /**
     * @return float
     */
    public function getSrvOptValeur()
    {
        return $this->srvOptValeur;
    }

    /**
     * @param float $srvOptValeur
     */
    public function setSrvOptValeur($srvOptValeur)
    {
        $this->srvOptValeur = $srvOptValeur;
    }

    /**
     * @return DevServiceOptionType
     */
    public function getLvServiceOptionType()
    {
        return $this->lvServiceOptionType;
    }

    /**
     * @param DevServiceOptionType $lvServiceOptionType
     */
    public function setLvServiceOptionType($lvServiceOptionType)
    {
        $this->lvServiceOptionType = $lvServiceOptionType;
    }

    /**
     * @return DevServiceOptionValeurType
     */
    public function getLvServiceOptionValeurType()
    {
        return $this->lvServiceOptionValeurType;
    }

    /**
     * @param DevServiceOptionValeurType $lvServiceOptionValeurType
     */
    public function setLvServiceOptionValeurType($lvServiceOptionValeurType)
    {
        $this->lvServiceOptionValeurType = $lvServiceOptionValeurType;
    }

    /**
     * @return mixed
     */
    public function getLvServices()
    {
        return $this->lvServices;
    }

    /**
     * @param mixed $lvServices
     */
    public function setLvServices($lvServices)
    {
        $this->lvServices = $lvServices;
    }

    /**
     * @return string
     */
    public function getServiceOptionString()
    {
        return $this->lvServiceOptionType->getSrvOptTpLabel() . ' - '
            . $this->srvOptLabel . ' (' . $this->getServiceValeurString() . ')';
    }

    /**
     * @return string
     */
    public function getServiceValeurString()
    {
        $_option_valeur = empty($this->srvOptValeur) ? 0 : $this->srvOptValeur;

        // Gratuit
        if ($this->lvServiceOptionValeurType->getSrvOptValTpVal() == ValeurTypeName::ID_GRATUIT)
            $_valeur = 'Gratuit';

        // Augmentation en pourcentage
        if ($this->lvServiceOptionValeurType->getSrvOptValTpVal() == ValeurTypeName::ID_POURCENTAGE)
            $_valeur = '+' . $_option_valeur . '%';

        // Augmentation en €
        if ($this->lvServiceOptionValeurType->getSrvOptValTpVal() == ValeurTypeName::ID_EURO)
            $_valeur = '+' . $_option_valeur . '€';

        return $_valeur;
    }

    /**
     * @return mixed
     */
    public function getLvServiceClients()
    {
        return $this->lvServiceClients;
    }

    /**
     * @param mixed $lvServiceClients
     */
    public function setLvServiceClients($lvServiceClients)
    {
        $this->lvServiceClients = $lvServiceClients;
    }
}
