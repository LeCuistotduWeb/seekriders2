<?php
namespace App\Entity;

class SpotSearch {

    private $title;
    private $type;

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

}