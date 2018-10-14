<?php

namespace App\Techzara\Service\MetierManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * DevRole
 *
 * @ORM\Table(name="tz_portfolio_type")
 * @UniqueEntity(fields="pfTpLabel", message="Nom déjà pris")
 * @ORM\Entity
 */
class DevPortfolioType
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
     * @ORM\Column(name="pf_tp_label", type="string", length=255, nullable=true)
     */
    private $pfTpLabel;

    /**
     * @ORM\OneToMany(targetEntity="App\Techzara\Service\MetierManagerBundle\Entity\DevPortfolio", mappedBy="lvPortfolioType", cascade={"persist", "remove"})
     */
    private $lvPortfolios;


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
    public function getPfTpLabel()
    {
        return $this->pfTpLabel;
    }

    /**
     * @param string $pfTpLabel
     */
    public function setPfTpLabel($pfTpLabel)
    {
        $this->pfTpLabel = $pfTpLabel;
    }

    /**
     * @return mixed
     */
    public function getLvPortfolios()
    {
        return $this->lvPortfolios;
    }

    /**
     * @param mixed $lvPortfolios
     */
    public function setLvPortfolios($lvPortfolios)
    {
        $this->lvPortfolios = $lvPortfolios;
    }
}
