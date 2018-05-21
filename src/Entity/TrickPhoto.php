<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickPhotoRepository")
 */
class TrickPhoto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\Image(
     *     minWidth = 200,
     *     maxWidth = 1500,
     *     minHeight = 200,
     *     maxHeight = 1200
     * )
     */
    private $adress;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="trickPhotos")
     * @ORM\JoinColumn(nullable=true)
     */
    private $trick;

    public function getId()
    {
        return $this->id;
    }
    public function getAdress()
    {
        return $this->adress;
    }

    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick($trick): self
    {
        $this->trick = $trick;

        return $this;
    }
}
