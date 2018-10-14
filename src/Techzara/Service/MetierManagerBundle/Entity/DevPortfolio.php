<?php

namespace App\Techzara\Service\MetierManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * DevPortfolio
 *
 * @ORM\Table(name="tz_portfolio")
 * @ORM\Entity
 */
class DevPortfolio
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
     * @ORM\Column(name="pf_title", type="string", length=255, nullable=true)
     */
    private $pfTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="pf_url", type="string", length=255, nullable=true)
     */
    private $pfUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="pf_description", type="string", length=255, nullable=true)
     */
    private $pfDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="pf_image_url", type="string", length=255, nullable=true)
     */
    private $pfImageUrl;

    /**
     * @Gedmo\Slug(fields={"pfTitle"}, updatable=true)
     * @ORM\Column(name="pf_slug", type="string", length=255)
     */
    private $pfSlug;

    /**
     * @var DevPortfolioType
     *
     * @ORM\ManyToOne(targetEntity="App\Techzara\Service\MetierManagerBundle\Entity\DevPortfolioType", inversedBy="lvPortfolios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pf_tp_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $lvPortfolioType;


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
    public function getPfTitle()
    {
        return $this->pfTitle;
    }

    /**
     * @param string $pfTitle
     */
    public function setPfTitle($pfTitle)
    {
        $this->pfTitle = $pfTitle;
    }

    /**
     * @return string
     */
    public function getPfUrl()
    {
        return $this->pfUrl;
    }

    /**
     * @param string $pfUrl
     */
    public function setPfUrl($pfUrl)
    {
        $this->pfUrl = $pfUrl;
    }

    /**
     * @return string
     */
    public function getPfDescription()
    {
        return $this->pfDescription;
    }

    /**
     * @param string $pfDescription
     */
    public function setPfDescription($pfDescription)
    {
        $this->pfDescription = $pfDescription;
    }

    /**
     * @return string
     */
    public function getPfImageUrl()
    {
        return $this->pfImageUrl;
    }

    /**
     * @param string $pfImageUrl
     */
    public function setPfImageUrl($pfImageUrl)
    {
        $this->pfImageUrl = $pfImageUrl;
    }

    /**
     * @return mixed
     */
    public function getPfSlug()
    {
        return $this->pfSlug;
    }

    /**
     * @param mixed $pfSlug
     */
    public function setPfSlug($pfSlug)
    {
        $this->pfSlug = $pfSlug;
    }

    /**
     * @return DevPortfolioType
     */
    public function getLvPortfolioType()
    {
        return $this->lvPortfolioType;
    }

    /**
     * @param DevPortfolioType $lvPortfolioType
     */
    public function setLvPortfolioType($lvPortfolioType)
    {
        $this->lvPortfolioType = $lvPortfolioType;
    }
}
