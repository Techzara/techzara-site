<?php
/**
 * @author <julienrajerison5@gmail.com>.
 */
namespace App\Entity;

use App\Repository\ChallengeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChallengeRepository::class)
 */
class Challenge
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $debut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end;

    /**
     * @ORM\OneToMany(targetEntity=Subject::class, mappedBy="challenge")
     */
    private $subjects;

    /**
     * @ORM\OneToMany(targetEntity=ChallengePerCandidat::class, mappedBy="challenge")
     */
    private $challengePerCandidat;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActif;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Participants::class, mappedBy="challenge", cascade={"persist"})
     */
    private $participants;

    public function __construct()
    {
        $this->subjects = new ArrayCollection();
        $this->challengePerCandidat = new ArrayCollection();
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebut(): ?string
    {
        return $this->debut;
    }

    public function setDebut(?string $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    /**
     * @return Collection|Subject[]
     */
    public function getSubjects(): Collection
    {
        return $this->subjects;
    }

    public function addSubject(Subject $subject): self
    {
        if (!$this->subjects->contains($subject)) {
            $this->subjects[] = $subject;
            $subject->setChallenge($this);
        }

        return $this;
    }

    public function removeSubject(Subject $subject): self
    {
        if ($this->subjects->contains($subject)) {
            $this->subjects->removeElement($subject);
            // set the owning side to null (unless already changed)
            if ($subject->getChallenge() === $this) {
                $subject->setChallenge(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ChallengePerCandidat[]
     */
    public function getChallengePerCandidat(): Collection
    {
        return $this->challengePerCandidat;
    }

    public function addChallengePerCandidat(ChallengePerCandidat $challengePerCandidat): self
    {
        if (!$this->challengePerCandidat->contains($challengePerCandidat)) {
            $this->challengePerCandidat[] = $challengePerCandidat;
            $challengePerCandidat->setChallenge($this);
        }

        return $this;
    }

    public function removeChallengePerCandidat(ChallengePerCandidat $challengePerCandidat): self
    {
        if ($this->challengePerCandidat->contains($challengePerCandidat)) {
            $this->challengePerCandidat->removeElement($challengePerCandidat);
            // set the owning side to null (unless already changed)
            if ($challengePerCandidat->getChallenge() === $this) {
                $challengePerCandidat->setChallenge(null);
            }
        }

        return $this;
    }

    public function getIsActif(): ?bool
    {
        return $this->isActif;
    }

    public function setIsActif(bool $isActif): self
    {
        $this->isActif = $isActif;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Participants[]
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participants $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->setChallenge($this);
        }

        return $this;
    }

    public function removeParticipant(Participants $participant): self
    {
        if ($this->participants->contains($participant)) {
            $this->participants->removeElement($participant);
            // set the owning side to null (unless already changed)
            if ($participant->getChallenge() === $this) {
                $participant->setChallenge(null);
            }
        }

        return $this;
    }
}
