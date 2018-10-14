<?php

namespace App\Techzara\Service\MetierManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DevSlide
 *
 * @ORM\Table(name="tz_slide")
 * @ORM\Entity
 */
class DevSlide
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
     * @ORM\Column(name="sld_first_title", type="string", length=255, nullable=true)
     */
    private $sldFirstTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="sld_second_title", type="string", length=255, nullable=true)
     */
    private $sldSecondTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="sld_third_title", type="string", length=255, nullable=true)
     */
    private $sldThirdTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="sld_image_url", type="string", length=255, nullable=true)
     */
    private $sldImageUrl;


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
    public function getSldFirstTitle()
    {
        return $this->sldFirstTitle;
    }

    /**
     * @param string $sldFirstTitle
     */
    public function setSldFirstTitle($sldFirstTitle)
    {
        $this->sldFirstTitle = $sldFirstTitle;
    }

    /**
     * @return string
     */
    public function getSldSecondTitle()
    {
        return $this->sldSecondTitle;
    }

    /**
     * @param string $sldSecondTitle
     */
    public function setSldSecondTitle($sldSecondTitle)
    {
        $this->sldSecondTitle = $sldSecondTitle;
    }

    /**
     * @return string
     */
    public function getSldImageUrl()
    {
        return $this->sldImageUrl;
    }

    /**
     * @param string $sldImageUrl
     */
    public function setSldImageUrl($sldImageUrl)
    {
        $this->sldImageUrl = $sldImageUrl;
    }

    /**
     * @return string
     */
    public function getSldThirdTitle()
    {
        return $this->sldThirdTitle;
    }

    /**
     * @param string $sldThirdTitle
     */
    public function setSldThirdTitle($sldThirdTitle)
    {
        $this->sldThirdTitle = $sldThirdTitle;
    }
}
