<?php

namespace App\Techzara\Service\MetierManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DevTemoignage
 *
 * @ORM\Table(name="tz_temoignage")
 * @ORM\Entity
 */
class DevTemoignage
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
     * @ORM\Column(name="tm_message", type="text", nullable=true)
     */
    private $tmMessage;

    /**
     * @var string
     *
     * @ORM\Column(name="tm_nom_personne", type="string", length=255, nullable=true)
     */
    private $tmNomPersonne;

    /**
     * @var string
     *
     * @ORM\Column(name="tm_poste_personne", type="string", length=100, nullable=true)
     */
    private $tmPostePersonne;


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
    public function getTmMessage()
    {
        return $this->tmMessage;
    }

    /**
     * @param string $tmMessage
     */
    public function setTmMessage($tmMessage)
    {
        $this->tmMessage = $tmMessage;
    }

    /**
     * @return string
     */
    public function getTmNomPersonne()
    {
        return $this->tmNomPersonne;
    }

    /**
     * @param string $tmNomPersonne
     */
    public function setTmNomPersonne($tmNomPersonne)
    {
        $this->tmNomPersonne = $tmNomPersonne;
    }

    /**
     * @return string
     */
    public function getTmPostePersonne()
    {
        return $this->tmPostePersonne;
    }

    /**
     * @param string $tmPostePersonne
     */
    public function setTmPostePersonne($tmPostePersonne)
    {
        $this->tmPostePersonne = $tmPostePersonne;
    }
}
