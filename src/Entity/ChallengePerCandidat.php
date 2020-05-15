<?php

namespace App\Entity;

use App\Repository\ChallengePerCandidatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChallengePerCandidatRepository::class)
 */
class ChallengePerCandidat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Subject::class, inversedBy="challengePerCandidats")
     */
    private $subject;

    /**
     * @ORM\Column(type="string", length=4, nullable=true)
     */
    private $point;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $candidatRange;

    /**
     * @ORM\ManyToOne(targetEntity=Challenge::class, inversedBy="challengePerCandidat")
     */
    private $challenge;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(?Subject $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getPoint(): ?string
    {
        return $this->point;
    }

    public function setPoint(?string $point): self
    {
        $this->point = $point;

        return $this;
    }

    public function getCandidatRange(): ?string
    {
        return $this->candidatRange;
    }

    public function setCandidatRange(?string $candidatRange): self
    {
        $this->candidatRange = $candidatRange;

        return $this;
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
}
