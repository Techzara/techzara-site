<?php

namespace App\Techzara\Service\MetierManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * DevFaqTranslation
 *
 * @ORM\Table(name="tz_faq_translation")
 * @ORM\Entity
 */
class DevFaqTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="faqt_question", type="text")
     */
    private $faqtQuestion;

    /**
     * @var string
     *
     * @ORM\Column(name="faqt_response", type="text")
     */
    private $faqttResponse;

    /**
     * @return string
     */
    public function getFaqtQuestion()
    {
        return $this->faqtQuestion;
    }

    /**
     * @param string $faqtQuestion
     */
    public function setFaqtQuestion($faqtQuestion)
    {
        $this->faqtQuestion = $faqtQuestion;
    }

    /**
     * @return string
     */
    public function getFaqttResponse()
    {
        return $this->faqttResponse;
    }

    /**
     * @param string $faqttResponse
     */
    public function setFaqttResponse($faqttResponse)
    {
        $this->faqttResponse = $faqttResponse;
    }
}
