<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * @ORM\Entity(repositoryClass="App\Repository\SpotPictureRepository")
 * @Vich\Uploadable()
 */
class SpotPicture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"show_post"})
     */
    private $id;

    /**
     * @var File|null
     * @Assert\All({
     *   @Assert\Image(mimeTypes="image/jpeg")
     * })
     * @Vich\UploadableField(mapping="spot_image", fileNameProperty="filename")
     * @Groups({"show_post"})
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_post"})
     */
    private $filename;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Spot", inversedBy="pictures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $spotPictures;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return null|File
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param null|File $imageFile
     * @return self
     */
    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    public function getSpotPictures(): ?Spot
    {
        return $this->spotPictures;
    }

    public function setSpotPictures(?Spot $spotPictures): self
    {
        $this->spotPictures = $spotPictures;

        return $this;
    }
}
