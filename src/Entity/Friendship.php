<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FriendshipRepository")
 */
class Friendship
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="friendship")
     */
    private $user1;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * null = demande en cours
     * true = accepter
     * false = refuser   si refuser passé a null au bout de nTemps ?
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser1(): ?User
    {
        return $this->user1;
    }

    public function setUser1(?User $user1): self
    {
        $this->user1 = $user1;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUser2(): ?User
    {
        return $this->user2;
    }

    public function setUser2(?User $user2): self
    {
        $this->user2 = $user2;

        return $this;
    }
}
