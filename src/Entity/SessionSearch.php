<?php

namespace App\Entity;

/**
 * Class SessionSearch
 * @package App\Entity
 */
class SessionSearch
{
    /**
     * @var \DateTime|null
     */
    private $startDateAt;

    /**
     * @var \DateTime|null
     */
    private $endDateAt;

    /**
     * @var String|null
     */
    private $city;

    public function getStartDateAt(): ?\DateTimeInterface
    {
        return $this->startDateAt;
    }

    public function setStartDateAt(?\DateTimeInterface $startDateAt): self
    {
        $this->startDateAt = $startDateAt;

        return $this;
    }

    public function getEndDateAt(): ?\DateTimeInterface
    {
        return $this->endDateAt;
    }

    public function setEndDateAt(?\DateTimeInterface $endDateAt): self
    {
        $this->endDateAt = $endDateAt;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }
}
