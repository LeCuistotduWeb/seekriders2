<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Contact
 * @package App\Entity
 */
class Contact
{
    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="2",
     *     max="50",
     *     minMessage="Votre nom doit comporter plus de 2 caractères",
     *     maxMessage="Votre nom doit comporter moins de 50 caractères")
     */
    private $firstname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="3",
     *     max="50",
     *     minMessage="Votre object doit comporter plus de 3 caractères",
     *     maxMessage="Votre object doit comporter moins de 50 caractères"
     * )
     */
    private $object;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min="3", minMessage="Votre message doit comporter plus de 3 caractères")
     */
    private $message;


    private $rgpd;

    /**
     * @return null|string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param null|string $firstname
     * @return Contact
     */
    public function setFirstname(?string $firstname): Contact
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     * @return Contact
     */
    public function setEmail(?string $email): Contact
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getObject(): ?string
    {
        return $this->object;
    }

    /**
     * @param null|string $object
     * @return Contact
     */
    public function setObject(?string $object): Contact
    {
        $this->object = $object;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param null|string $message
     * @return Contact
     */
    public function setMessage(?string $message): Contact
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRgpd()
    {
        return $this->rgpd;
    }

    /**
     * @param mixed $rgpd
     */
    public function setRgpd($rgpd): void
    {
        $this->rgpd = $rgpd;
    }


}
