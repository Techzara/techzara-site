<?php

namespace App\Techzara\Service\MetierManagerBundle\Entity;

use App\Techzara\Service\MetierManagerBundle\Form\DevServiceTypeType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * DevService
 *
 * @ORM\Table(name="tz_service")
 * @UniqueEntity(fields="srvLabel", message="Ce source d'energie existe déjà")
 * @ORM\Entity
 */
class DevService
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
     * @ORM\Column(name="srv_label", type="string", length=255, nullable=true)
     */
    private $srvLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="srv_desc", type="text", nullable=true)
     */
    private $srvDesc;

    /**
     * @var float
     *
     * @ORM\Column(name="srv_prix", type="float", nullable=true)
     */
    private $srvPrix;

    /**
     * @var float
     *
     * @ORM\Column(name="srv_reduction", type="float", nullable=true)
     */
    private $srvReduction;

    /**
     * @Gedmo\Slug(fields={"srvLabel"}, updatable=true)
     * @ORM\Column(name="srv_slug", type="string", length=255)
     */
    private $srvSlug;

    /**
     * @var DevServiceTypeType
     *
     * @ORM\ManyToOne(targetEntity="App\Techzara\Service\MetierManagerBundle\Entity\DevServiceType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tz_srv_tp_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $lvServiceType;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Techzara\Service\MetierManagerBundle\Entity\DevServiceOption", inversedBy="lvServices")
     * @ORM\JoinTable(name="tz_service_service_option",
     *   joinColumns={
     *     @ORM\JoinColumn(name="tz_srv_id", referencedColumnName="id", onDelete="cascade")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tz_srv_opt_id", referencedColumnName="id", onDelete="cascade")
     *   }
     * )
     */
    private $lvServiceOptions;


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
    public function getSrvLabel()
    {
        return $this->srvLabel;
    }

    /**
     * @param string $srvLabel
     */
    public function setSrvLabel($srvLabel)
    {
        $this->srvLabel = $srvLabel;
    }

    /**
     * @return string
     */
    public function getSrvDesc()
    {
        return $this->srvDesc;
    }

    /**
     * @param string $srvDesc
     */
    public function setSrvDesc($srvDesc)
    {
        $this->srvDesc = $srvDesc;
    }

    /**
     * @return float
     */
    public function getSrvPrix()
    {
        return $this->srvPrix;
    }

    /**
     * @param float $srvPrix
     */
    public function setSrvPrix($srvPrix)
    {
        $this->srvPrix = $srvPrix;
    }

    /**
     * @return float
     */
    public function getSrvReduction()
    {
        return $this->srvReduction;
    }

    /**
     * @param float $srvReduction
     */
    public function setSrvReduction($srvReduction)
    {
        $this->srvReduction = $srvReduction;
    }

    /**
     * @return DevServiceTypeType
     */
    public function getLvServiceType()
    {
        return $this->lvServiceType;
    }

    /**
     * @param DevServiceTypeType $lvServiceType
     */
    public function setLvServiceType($lvServiceType)
    {
        $this->lvServiceType = $lvServiceType;
    }

    /**
     * @return mixed
     */
    public function getLvServiceOptions()
    {
        return $this->lvServiceOptions;
    }

    /**
     * @param mixed $lvServiceOptions
     */
    public function setLvServiceOptions($lvServiceOptions)
    {
        $this->lvServiceOptions = $lvServiceOptions;
    }

    /**
     * @return string
     */
    public function getSrvLabelString()
    {
        return $this->srvLabel . ' (' . $this->srvPrix . ' €)';
    }

    /**
     * @return mixed
     */
    public function getSrvSlug()
    {
        return $this->srvSlug;
    }

    /**
     * @param mixed $srvSlug
     */
    public function setSrvSlug($srvSlug)
    {
        $this->srvSlug = $srvSlug;
    }
}
