<?php

namespace App\Techzara\Service\MetierManagerBundle\Entity;

use App\Techzara\Service\MetierManagerBundle\Form\DevServiceTypeType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * DevService
 *
 * @ORM\Table(name="tz_service_option_valeur_type")
 * @UniqueEntity(fields="srvLabel", message="Nom déjà pris")
 * @ORM\Entity
 */
class DevServiceOptionValeurType
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
     * @var boolean
     *
     * @ORM\Column(name="srv_opt_val_tp_is_percent", type="boolean", nullable=true)
     */
    private $srvOptValTpIsPercent = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="srv_opt_val_tp_is_reduction", type="boolean", nullable=true)
     */
    private $srvOptValTpIsReduction = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="srv_opt_val_tp_is_gratuit", type="boolean", nullable=true)
     */
    private $srvOptValTpIsGratuit = false;

    /**
     * @var integer
     *
     * @ORM\Column(name="srv_opt_val_tp_val", type="smallint", options={"default" = 0}))
     */
    private $srvOptValTpVal = 0;


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
    public function getSrvOptValTpIsPercent()
    {
        return $this->srvOptValTpIsPercent;
    }

    /**
     * @param string $srvOptValTpIsPercent
     */
    public function setSrvOptValTpIsPercent($srvOptValTpIsPercent)
    {
        $this->srvOptValTpIsPercent = $srvOptValTpIsPercent;
    }

    /**
     * @return string
     */
    public function getSrvOptValTpIsReduction()
    {
        return $this->srvOptValTpIsReduction;
    }

    /**
     * @param string $srvOptValTpIsReduction
     */
    public function setSrvOptValTpIsReduction($srvOptValTpIsReduction)
    {
        $this->srvOptValTpIsReduction = $srvOptValTpIsReduction;
    }

    /**
     * @return string
     */
    public function getSrvOptValTpIsGratuit()
    {
        return $this->srvOptValTpIsGratuit;
    }

    /**
     * @param string $srvOptValTpIsGratuit
     */
    public function setSrvOptValTpIsGratuit($srvOptValTpIsGratuit)
    {
        $this->srvOptValTpIsGratuit = $srvOptValTpIsGratuit;
    }

    /**
     * @return int
     */
    public function getSrvOptValTpVal()
    {
        return $this->srvOptValTpVal;
    }

    /**
     * @param int $srvOptValTpVal
     */
    public function setSrvOptValTpVal($srvOptValTpVal)
    {
        $this->srvOptValTpVal = $srvOptValTpVal;
    }
}
