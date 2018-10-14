<?php

namespace App\Techzara\Service\MetierManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * DevCmsTranslation
 *
 * @ORM\Table(name="tz_cms_translation")
 * @ORM\Entity
 */
class DevCmsTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="cmst_title", type="string", length=255)
     */
    private $cmstTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="cmst_content", type="text")
     */
    private $cmstContent;

    /**
     * @Gedmo\Slug(fields={"cmstTitle"}, updatable=false)
     * @ORM\Column(name="cmst_slug", type="string", length=255, unique=true)
     */
    private $cmstSlug;

    /**
     * Set cmstTitle
     *
     * @param string $cmstTitle
     *
     * @return DevCmsTranslation
     */
    public function setCmstTitle($cmstTitle)
    {
        $this->cmstTitle = $cmstTitle;

        return $this;
    }

    /**
     * Get cmstTitle
     *
     * @return string
     */
    public function getCmstTitle()
    {
        return $this->cmstTitle;
    }

    /**
     * Set cmstContent
     *
     * @param string $cmstContent
     *
     * @return DevCmsTranslation
     */
    public function setCmstContent($cmstContent)
    {
        $this->cmstContent = $cmstContent;

        return $this;
    }

    /**
     * Get cmstContent
     *
     * @return string
     */
    public function getCmstContent()
    {
        return $this->cmstContent;
    }

    /**
     * Set cmstSlug
     *
     * @param string $cmstSlug
     *
     * @return DevCmsTranslation
     */
    public function setCmstSlug($cmstSlug)
    {
        $this->cmstSlug = $cmstSlug;

        return $this;
    }

    /**
     * Get cmstSlug
     *
     * @return string
     */
    public function getCmstSlug()
    {
        return $this->cmstSlug;
    }
}
