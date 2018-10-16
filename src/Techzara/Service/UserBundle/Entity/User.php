<?php

namespace App\Techzara\Service\UserBundle\Entity;

use App\Techzara\Service\MetierManagerBundle\Entity\DevRole;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Users
 *
 * @ORM\Table(name="tz_user", uniqueConstraints={@ORM\UniqueConstraint(name="username_canonical_UNIQUE", columns={"username_canonical"}), @ORM\UniqueConstraint(name="email_canonical_UNIQUE", columns={"email_canonical"}), @ORM\UniqueConstraint(name="confirmation_token_UNIQUE", columns={"confirmation_token"})})
 * @UniqueEntity(fields="username", message="Nom d'utilisateur déjà existant")
 * @UniqueEntity(fields="email", message="Email déjà existant")
 * @ORM\Entity(repositoryClass="UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_firstname", type="string", length=255, nullable=true)
     */
    private $usrFirstname;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_lastname", type="string", length=255, nullable=true)
     */
    private $usrLastname;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_address", type="string", length=255, nullable=true)
     */
    private $usrAddress;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="usr_date_create", type="datetime", nullable=true)
     */
    private $usrDateCreate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="usr_date_update", type="datetime", nullable=true)
     */
    private $usrDateUpdate;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_phone", type="string", length=45, nullable=true)
     */
    private $usrPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_social", type="string", length=45, nullable=true)
     */
    private $social_count;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_photo", type="string", length=255, nullable=true)
     */
    private $usrPhoto;

    /**
     * @var boolean
     *
     * @ORM\Column(name="usr_is_valid", type="boolean")
     */
    private $usrIsValid = false;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_nom_entreprise", type="string", length=100, nullable=true)
     */
    private $usrNomEntreprise;

    /**
     * @var DevRole
     *
     * @ORM\ManyToOne(targetEntity="App\Techzara\Service\MetierManagerBundle\Entity\DevRole")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tz_role_id", referencedColumnName="id")
     * })
     */
    private $tzRole;

    /**
     * @ORM\ManyToMany(targetEntity="App\Techzara\Service\MetierManagerBundle\Entity\DevUserServiceClient", mappedBy="lvUsers", cascade={"persist", "remove"})
     */
    private $lvUserServiceClients;

    /**
     * @ORM\OneToMany(targetEntity="App\Techzara\Service\MetierManagerBundle\Entity\DevServiceClient", mappedBy="lvUser", cascade={"persist", "remove"})
     */
    private $lvServiceClients;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_tache", type="string", length=255, nullable=true)
     */
    private $tache;

    /**
     * @var string
     *
     * @ORM\Column(name="admin_testimonial", type="string", length=255, nullable=true)
     */
    private $quotes;


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->usrDateCreate = new \DateTime();
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
     * @return string
     */
    public function getUsrFirstname()
    {
        return $this->usrFirstname;
    }

    /**
     * @param string $usrFirstname
     */
    public function setUsrFirstname($usrFirstname)
    {
        $this->usrFirstname = $usrFirstname;
    }

    /**
     * @return string
     */
    public function getUsrLastname()
    {
        return $this->usrLastname;
    }

    /**
     * @param string $usrLastname
     */
    public function setUsrLastname($usrLastname)
    {
        $this->usrLastname = $usrLastname;
    }

    /**
     * @return \DateTime
     */
    public function getUsrDateUpdate()
    {
        return $this->usrDateUpdate;
    }

    /**
     * @param \DateTime $usrDateUpdate
     */
    public function setUsrDateUpdate($usrDateUpdate)
    {
        $this->usrDateUpdate = $usrDateUpdate;
    }

    /**
     * @return string
     */
    public function getUsrPhoto()
    {
        return $this->usrPhoto;
    }

    /**
     * @param string $usrPhoto
     */
    public function setUsrPhoto($usrPhoto)
    {
        $this->usrPhoto = $usrPhoto;
    }

    /**
     * @return DevRole
     */
    public function getTzRole()
    {
        return $this->tzRole;
    }

    /**
     * @param DevRole $tzRole
     */
    public function setTzRole($tzRole)
    {
        $this->tzRole = $tzRole;
    }

    /**
     * @return string
     */
    public function getUsrAddress()
    {
        return $this->usrAddress;
    }

    /**
     * @param string $usrAddress
     */
    public function setUsrAddress($usrAddress)
    {
        $this->usrAddress = $usrAddress;
    }

    /**
     * @return \DateTime
     */
    public function getUsrDateCreate()
    {
        return $this->usrDateCreate;
    }

    /**
     * @param \DateTime $usrDateCreate
     */
    public function setUsrDateCreate($usrDateCreate)
    {
        $this->usrDateCreate = $usrDateCreate;
    }

    /**
     * @return string
     */
    public function getUsrPhone()
    {
        return $this->usrPhone;
    }

    /**
     * @param string $usrPhone
     */
    public function setUsrPhone($usrPhone)
    {
        $this->usrPhone = $usrPhone;
    }

    /**
     * Get fullname
     *
     * @return string
     */
    public function getUsrFullname()
    {
        return $this->usrFirstname . ' ' . $this->usrLastname;
    }

    /**
     * @return bool
     */
    public function isUsrIsValid()
    {
        return $this->usrIsValid;
    }

    /**
     * @param bool $usrIsValid
     */
    public function setUsrIsValid($usrIsValid)
    {
        $this->usrIsValid = $usrIsValid;
    }

    /**
     * @return string
     */
    public function getUsrNomEntreprise()
    {
        return $this->usrNomEntreprise;
    }

    /**
     * @param string $usrNomEntreprise
     */
    public function setUsrNomEntreprise($usrNomEntreprise)
    {
        $this->usrNomEntreprise = $usrNomEntreprise;
    }

    /**
     * @return mixed
     */
    public function getLvUserServiceClients()
    {
        return $this->lvUserServiceClients;
    }

    /**
     * @param mixed $lvUserServiceClients
     */
    public function setLvUserServiceClients($lvUserServiceClients)
    {
        $this->lvUserServiceClients = $lvUserServiceClients;
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

    /**
     * Get entreprise
     *
     * @return string
     */
    public function getUsrEntreprise()
    {
        return $this->usrNomEntreprise . ' (' . $this->email . ')';
    }

    /**
     * @return string
     */
    public function getSocialCount()
    {
        return $this->social_count;
    }

    /**
     * @param string $social_count
     */
    public function setSocialCount($social_count)
    {
        $this->social_count = $social_count;
    }

    /**
     * @return string
     */
    public function getQuotes()
    {
        return $this->quotes;
    }

    /**
     * @param string $quotes
     */
    public function setQuotes($quotes)
    {
        $this->quotes = $quotes;
    }

    /**
     * @return string
     */
    public function getTache()
    {
        return $this->tache;
    }

    /**
     * @param string $tache
     */
    public function setTache($tache)
    {
        $this->tache = $tache;
    }




}
