<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserPictureRepository")
 * @Vich\Uploadable()
 */
class UserPicture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var File|null
     * @Assert\All({
     *   @Assert\Image(mimeTypes="image/jpeg")
     * })
     * @Vich\UploadableField(mapping="user_image", fileNameProperty="filename")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="avatar", cascade={"persist"})
     */
    private $userAvatar;

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

    public function getUserAvatar(): ?User
    {
        return $this->userAvatar;
    }

    public function setUserAvatar(?User $userAvatar): self
    {
        $this->userAvatar = $userAvatar;

        // set (or unset) the owning side of the relation if necessary
        $newAvatar = $userAvatar === null ? null : $this;
        if ($newAvatar !== $userAvatar->getAvatar()) {
            $userAvatar->setAvatar($newAvatar);
        }

        return $this;
    }
}
