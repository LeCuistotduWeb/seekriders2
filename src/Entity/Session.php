<?php

namespace App\Entity;

use App\Validator\SessionStartDate;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SessionRepository")
 */
class Session
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"show_post"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3, minMessage="Le titre doit avoir plus de 3 caractères")
     * @Groups({"show_post"})
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"show_post"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @SessionStartDate()
     * @Groups({"show_post"})
     */
    private $startDateAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"show_post"})
     */
    private $endDateAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="sessions")
     */
    private $participants;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Spot", inversedBy="sessions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $spot;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="mySessions")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"show_post"})
     */
    private $author;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"show_post"})
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"show_post"})
     */
    private $isContest;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStartDateAt(): ?\DateTimeInterface
    {
        return $this->startDateAt;
    }

    public function setStartDateAt(\DateTimeInterface $startDateAt): self
    {
        $this->startDateAt = $startDateAt;

        return $this;
    }

    public function getEndDateAt(): ?\DateTimeInterface
    {
        return $this->endDateAt;
    }

    public function setEndDateAt(\DateTimeInterface $endDateAt): self
    {
        $this->endDateAt = $endDateAt;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(User $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
        }

        return $this;
    }

    public function removeParticipant(User $participant): self
    {
        if ($this->participants->contains($participant)) {
            $this->participants->removeElement($participant);
        }

        return $this;
    }

    public function getSpot(): ?Spot
    {
        return $this->spot;
    }

    public function setSpot(?Spot $spot): self
    {
        $this->spot = $spot;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPicture()
    {
        return $this->getSpot()->getPicture();
    }

    public function getLocation()
    {
        return $this->getSpot()->getLocation();
    }

    public function isParticipating(User $user)
    {
        foreach ($this->participants as $participant){
            if($participant === $user) return true;
        }
        return false;
    }

    public function toArray()
    {
        $objectArray = get_object_vars($this);

        if($this->getSpot()){
            $objectArray['spot'] = $this->getSpot()->toArray();
        }
        return $objectArray;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsContest(): ?bool
    {
        return $this->isContest;
    }

    public function setIsContest(?bool $isContest): self
    {
        $this->isContest = $isContest;

        return $this;
    }
}
