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

    /**
     * @ORM\Column(type="boolean")
     */
    private $isFrontPhoto;

    public function __construct()
    {
        $this->isFrontPhoto = false;
    }

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


    public function delete($uploader, $uploadDir)
    {
        if ($this->getTrick()->getFrontPhoto() == $this) {
            $this->getTrick()->setFrontPhoto(null);
        }
        $uploader->remove($this->getAdress(), $uploadDir);
    }

    public function add($uploader, $uploadDir)
    {
        $filename = $uploader->upload($this->getAdress(), $uploadDir);
        $this->setAdress($filename);
    }

    public function getIsFrontPhoto(): ?bool
    {
        return $this->isFrontPhoto;
    }

    public function setIsFrontPhoto(bool $isFrontPhoto): self
    {
        $this->isFrontPhoto = $isFrontPhoto;
        if ($isFrontPhoto) {
            $this->getTrick()->setFrontPhoto($this);
        }

        return $this;
    }
}
