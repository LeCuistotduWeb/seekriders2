<?php
namespace App\Entity;

class SpotSearch {

    /**
     * @var string|null
     */
    private $title;

    /**
     * @var string|null
     */
    private $type;

    /***
     * @var int|null
     */
    private $lat;

    /**
     * @var int|null
     */
    private $lng;

    /**
     * @var int|null
     */
    private $distance;

    /**
     * @var string|null
     */
    private $address;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return SpotSearch
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return SpotSearch
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLat(): ?int
    {
        return $this->lat;
    }

    /**
     * @param int|null $lat
     * @return SpotSearch
     */
    public function setLat(?int $lat): SpotSearch
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLng(): ?int
    {
        return $this->lng;
    }

    /**
     * @param int|null $lng
     * @return SpotSearch
     */
    public function setLng(?int $lng): SpotSearch
    {
        $this->lng = $lng;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDistance(): ?int
    {
        return $this->distance;
    }

    /**
     * @param int|null $distance
     * @return SpotSearch
     */
    public function setDistance(?int $distance): SpotSearch
    {
        $this->distance = $distance;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param null|string $address
     * @return SpotSearch
     */
    public function setAddress(?string $address): SpotSearch
    {
        $this->address = $address;
        return $this;
    }


}