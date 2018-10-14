<?php

namespace App\Techzara\Service\MetierManagerBundle\Entity;

use App\Techzara\Service\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * DevClient
 *
 * @ORM\Table(name="tz_user_service_client")
 * @ORM\Entity
 */
class DevUserServiceClient
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
     * @ORM\Column(name="usr_srv_clt_date_debut", type="datetime", nullable=true)
     */
    private $usrSrvCltDateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="usr_srv_clt_date_attribution", type="datetime", nullable=true)
     */
    private $usrSrvCltDateAttribution;

    /**
     * @var float
     *
     * @ORM\Column(name="usr_srv_clt_estimation", type="float", nullable=true)
     */
    private $usrSrvCltEstimation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="usr_srv_clt_date_finalisation", type="datetime", nullable=true)
     */
    private $usrSrvCltDateFinalisation;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Techzara\Service\UserBundle\Entity\User", inversedBy="lvUserServiceClients")
     * @ORM\JoinTable(name="tz_user_service_client_user",
     *   joinColumns={
     *     @ORM\JoinColumn(name="tz_usr_srv_clt_id", referencedColumnName="id", onDelete="cascade")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tz_usr_id", referencedColumnName="id", onDelete="cascade")
     *   }
     * )
     */
    private $lvUsers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Techzara\Service\UserBundle\Entity\User")
     * @ORM\JoinTable(name="tz_user_service_client_tester",
     *   joinColumns={
     *     @ORM\JoinColumn(name="tz_usr_srv_clt_id", referencedColumnName="id", onDelete="cascade")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tz_tst_id", referencedColumnName="id", onDelete="cascade")
     *   }
     * )
     */
    private $lvTesters;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Techzara\Service\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tz_usr_admin_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $lvAdmin;

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
     * Constructor
     */
    public function __construct()
    {
        $this->usrSrvCltDateAttribution = new \DateTime();
    }

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
    public function getUsrSrvCltDateDebut()
    {
        return $this->usrSrvCltDateDebut;
    }

    /**
     * @param \DateTime $usrSrvCltDateDebut
     */
    public function setUsrSrvCltDateDebut($usrSrvCltDateDebut)
    {
        $this->usrSrvCltDateDebut = $usrSrvCltDateDebut;
    }

    /**
     * @return \DateTime
     */
    public function getUsrSrvCltDateAttribution()
    {
        return $this->usrSrvCltDateAttribution;
    }

    /**
     * @param \DateTime $usrSrvCltDateAttribution
     */
    public function setUsrSrvCltDateAttribution($usrSrvCltDateAttribution)
    {
        $this->usrSrvCltDateAttribution = $usrSrvCltDateAttribution;
    }

    /**
     * @return float
     */
    public function getUsrSrvCltEstimation()
    {
        return $this->usrSrvCltEstimation;
    }

    /**
     * @param float $usrSrvCltEstimation
     */
    public function setUsrSrvCltEstimation($usrSrvCltEstimation)
    {
        $this->usrSrvCltEstimation = $usrSrvCltEstimation;
    }

    /**
     * @return \DateTime
     */
    public function getUsrSrvCltDateFinalisation()
    {
        return $this->usrSrvCltDateFinalisation;
    }

    /**
     * @param \DateTime $usrSrvCltDateFinalisation
     */
    public function setUsrSrvCltDateFinalisation($usrSrvCltDateFinalisation)
    {
        $this->usrSrvCltDateFinalisation = $usrSrvCltDateFinalisation;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLvUsers()
    {
        return $this->lvUsers;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $lvUsers
     */
    public function setLvUsers($lvUsers)
    {
        $this->lvUsers = $lvUsers;
    }

    /**
     * @return User
     */
    public function getLvAdmin()
    {
        return $this->lvAdmin;
    }

    /**
     * @param User $lvAdmin
     */
    public function setLvAdmin($lvAdmin)
    {
        $this->lvAdmin = $lvAdmin;
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLvTesters()
    {
        return $this->lvTesters;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $lvTesters
     */
    public function setLvTesters($lvTesters)
    {
        $this->lvTesters = $lvTesters;
    }
}
