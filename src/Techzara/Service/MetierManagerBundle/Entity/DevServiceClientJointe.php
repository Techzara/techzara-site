<?php

namespace App\Techzara\Service\MetierManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DevRole
 *
 * @ORM\Table(name="tz_service_client_jointe")
 * @ORM\Entity
 */
class DevServiceClientJointe
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
     * @ORM\Column(name="srv_clt_jt_ext", type="string", length=10, nullable=true)
     */
    private $srvCltJtExt;

    /**
     * @var string
     *
     * @ORM\Column(name="srv_clt_jt_path", type="string", length=255, nullable=true)
     */
    private $srvCltJtPath;

    /**
     * @var DevServiceClient
     *
     * @ORM\ManyToOne(targetEntity="App\Techzara\Service\MetierManagerBundle\Entity\DevServiceClient", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tz_srv_clt_id", referencedColumnName="id", onDelete="CASCADE")
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
     * @return string
     */
    public function getSrvCltJtExt()
    {
        return $this->srvCltJtExt;
    }

    /**
     * @param string $srvCltJtExt
     */
    public function setSrvCltJtExt($srvCltJtExt)
    {
        $this->srvCltJtExt = $srvCltJtExt;
    }

    /**
     * @return string
     */
    public function getSrvCltJtPath()
    {
        return $this->srvCltJtPath;
    }

    /**
     * @param string $srvCltJtPath
     */
    public function setSrvCltJtPath($srvCltJtPath)
    {
        $this->srvCltJtPath = $srvCltJtPath;
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
}
