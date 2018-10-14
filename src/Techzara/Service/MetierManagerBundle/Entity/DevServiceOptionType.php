<?php

namespace App\Techzara\Service\MetierManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * DevServiceOptionType
 *
 * @ORM\Table(name="tz_service_option_type")
 * @UniqueEntity(fields="srvOptTpLabel", message="Nom déjà pris")
 * @ORM\Entity
 */
class DevServiceOptionType
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
     * @ORM\Column(name="srv_opt_tp_label", type="string", length=45, nullable=true)
     */
    private $srvOptTpLabel;


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
    public function getSrvOptTpLabel()
    {
        return $this->srvOptTpLabel;
    }

    /**
     * @param string $srvOptTpLabel
     */
    public function setSrvOptTpLabel($srvOptTpLabel)
    {
        $this->srvOptTpLabel = $srvOptTpLabel;
    }
}
