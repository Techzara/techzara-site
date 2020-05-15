<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubjectRepository::class)
 */
class Subject
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Challenge::class, inversedBy="subjects")
     */
    private $challenge;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $numero;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="subjects")
     */
    private $type;

    /**
     * @ORM\Column(type="text")
     */
    private $sujet;

    /**
     * @ORM\OneToMany(targetEntity=ChallengePerCandidat::class, mappedBy="subject")
     */
    private $challengePerCandidats;

    public function __construct()
    {
        $this->challengePerCandidats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChallenge(): ?Challenge
    {
        return $this->challenge;
    }

    public function setChallenge(?Challenge $challenge): self
    {
        $this->challenge = $challenge;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    /**
     * @return Collection|ChallengePerCandidat[]
     */
    public function getChallengePerCandidats(): Collection
    {
        return $this->challengePerCandidats;
    }

    public function addChallengePerCandidat(ChallengePerCandidat $challengePerCandidat): self
    {
        if (!$this->challengePerCandidats->contains($challengePerCandidat)) {
            $this->challengePerCandidats[] = $challengePerCandidat;
            $challengePerCandidat->setSubject($this);
        }

        return $this;
    }

    public function removeChallengePerCandidat(ChallengePerCandidat $challengePerCandidat): self
    {
        if ($this->challengePerCandidats->contains($challengePerCandidat)) {
            $this->challengePerCandidats->removeElement($challengePerCandidat);
            // set the owning side to null (unless already changed)
            if ($challengePerCandidat->getSubject() === $this) {
                $challengePerCandidat->setSubject(null);
            }
        }

        return $this;
    }
}
