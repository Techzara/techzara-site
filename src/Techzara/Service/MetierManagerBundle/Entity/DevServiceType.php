<?php

namespace App\Techzara\Service\MetierManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * DevServiceType
 *
 * @ORM\Table(name="tz_service_type")
 * @UniqueEntity(fields="srvTpLabel", message="Nom déjà pris")
 * @ORM\Entity
 */
class DevServiceType
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
     * @ORM\Column(name="srv_tp_label", type="string", length=45, nullable=true)
     */
    private $srvTpLabel;


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
    public function getSrvTpLabel()
    {
        return $this->srvTpLabel;
    }

    /**
     * @param string $srvTpLabel
     */
    public function setSrvTpLabel($srvTpLabel)
    {
        $this->srvTpLabel = $srvTpLabel;
    }
}
