<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpotRepository")
 */
class Spot
{
    const SPOT_TYPE = [
        0 => 'Street',
        1 => 'Skatepark'
    ];
    const PRICE = [
        0 => 'Nc',
        1 => 'Gratuit',
        2 => 'Payant',
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $paying;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="spotsCreated")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Location", inversedBy="spot", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SpotPicture", mappedBy="spotPictures", orphanRemoval=true, cascade={"persist"})
     */
    private $pictures;

    /**
     * @Assert\All({
     *  @Assert\Image(mimeTypes="image/jpeg")
     *})
     */
    private $picturesFiles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SpotLike", mappedBy="spot")
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Session", mappedBy="spot", orphanRemoval=true)
     */
    private $sessions;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->pictures = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->sessions = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPaying(): ?string
    {
        return $this->paying;
    }

    public function setPaying(?string $paying): self
    {
        $this->paying = $paying;

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

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSpotType(): string
    {
        return self::SPOT_TYPE[$this->type];
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

    public function getSpotPrice(): string
    {
        return self::PRICE[$this->paying];
    }

    public function getPicture(): ?SpotPicture
    {
        if($this->pictures->isEmpty()){
            return null;
        }
        return $this->pictures->first();
    }

    /**
     * @return Collection|SpotPicture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(SpotPicture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setSpotPictures($this);
        }

        return $this;
    }

    public function removePicture(SpotPicture $picture): self
    {
        if ($this->pictures->contains($picture)) {
            $this->pictures->removeElement($picture);
            // set the owning side to null (unless already changed)
            if ($picture->getSpotPictures() === $this) {
                $picture->setSpotPictures(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPicturesFiles()
    {
        return $this->picturesFiles;
    }

    /**
     * @param mixed $picturesFiles
     * @return Spot
     */
    public function setPicturesFiles($picturesFiles): self
    {
        foreach ($picturesFiles as $picturesFile) {
            $picture = New SpotPicture();
            $picture->setImageFile($picturesFile);
            $this->addPicture($picture);
        }
        $this->picturesFiles = $picturesFiles;
        return $this;
    }

    /**
     * @return Collection|SpotLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(SpotLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setSpot($this);
        }

        return $this;
    }

    public function removeLike(SpotLike $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getSpot() === $this) {
                $like->setSpot(null);
            }
        }

        return $this;
    }

    /**
     * permet de savoir si le spot a été ajouté en favoris par un user
     * @param User $user
     * @return bool
     */
    public function isLikeByUser(User $user): bool
    {
        foreach ($this->likes as $like){
            if($like->getUser() === $user) return true;
        }
        return false;
    }

    /**
     * @return Collection|Session[]
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setSpot($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->contains($session)) {
            $this->sessions->removeElement($session);
            // set the owning side to null (unless already changed)
            if ($session->getSpot() === $this) {
                $session->setSpot(null);
            }
        }

        return $this;
    }

    public function toArray()
    {
        $objectArray = get_object_vars($this);

        if($this->getAuthor()){
            $objectArray['author'] = $this->getAuthor()->getUsername();
        }
        if($this->getPicture()){
            $objectArray['spot_image'] = $this->getPicture()->getFilename();
        }else {
            $objectArray['spot_image'] = null;
        }
        if($this->getLocation()){
            $objectArray['location'] = $this->getLocation()->toArray();
        }
        return $objectArray;
    }
}
