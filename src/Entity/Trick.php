<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Iframe;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickRepository")
 */
class Trick
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(message = "The trick must have a name")
     * @Assert\Length(min = 3,
     *               minMessage = "The name must have at least 3 characters",
     *               max = 50,
     *               maxMessage = "The name can't have more than 50 characters"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message = "The trick must have a description")
     * @Assert\Length(min = 20,
     *               minMessage = "The description must have at least 20 characters"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TrickGroup", inversedBy="tricks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trickGroup;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="trick", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $comments;

    /**
    * @ORM\OneToMany(targetEntity="App\Entity\TrickPhoto", mappedBy="trick", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $trickPhotos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Video", mappedBy="trick", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $videos;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\TrickPhoto", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $frontPhoto = null;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->trickPhotos = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->creationDate = new \DateTime();
        $this->updateDate = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->updateDate;
    }

    public function setUpdateDate(\DateTimeInterface $updateDate): self
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    public function getTrickGroup(): ?TrickGroup
    {
        return $this->trickGroup;
    }

    public function setTrickGroup(?TrickGroup $trickGroup): self
    {
        $this->trickGroup = $trickGroup;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTrick($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($this === $comment->getTrick()) {
                $comment->setTrick(null);
            }
        }

        return $this;
    }


    public function getTrickPhotos()
    {
        return $this->trickPhotos;
    }

    public function addTrickPhoto(TrickPhoto $trickPhoto): self
    {
        if (!$this->trickPhotos->contains($trickPhoto)) {
            $this->trickPhotos[] = $trickPhoto;
            $trickPhoto->setTrick($this);
            if (null === $this->frontPhoto) {
                $this->setFrontPhoto($trickPhoto);
            }
        }

        return $this;
    }

    public function removeTrickPhoto(TrickPhoto $trickPhoto): self
    {
        if ($this->trickPhotos->contains($trickPhoto)) {
            $this->trickPhotos->removeElement($trickPhoto);
            // set the owning side to null (unless already changed)
            if ($this === $trickPhoto->getTrick()) {
                $trickPhoto->setTrick(null);
            }
            if ($this->frontPhoto === $trickPhoto) {
                $this->frontPhoto = null;
            }
        }

        return $this;
    }

    public function resetTrickPhotos()
    {
        $photos = $this->trickPhotos;
        $this->trickPhotos = new ArrayCollection();
        return $photos;
    }

    public function setTrickPhotos($trickPhotos): self
    {
        $this->trickPhotos = $trickPhotos;
        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setTrick($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->contains($video)) {
            $this->videos->removeElement($video);
            // set the owning side to null (unless already changed)
            if ($video->getTrick() === $this) {
                $video->setTrick(null);
            }
        }

        return $this;
    }

    public function resetVideos()
    {
        $videos = $this->videos;
        $this->videos = new ArrayCollection();
        return $videos;
    }

    public function setVideos($videos): self
    {
        $this->videos = $videos;
        return $this;
    }

    public function getFrontPhoto(): ?TrickPhoto
    {
        return $this->frontPhoto;
    }

    public function setFrontPhoto($frontPhoto): self
    {
        $this->frontPhoto = $frontPhoto;
        if ($frontPhoto !== null) {
            $this->frontPhoto->setTrick($this);
        }

        return $this;
    }

    public function ajaxData()
    {
        $trickData = array(
        "id" => $this->getId(),
        "name" => $this->getName(),
        "photo" => "no-photo.png",
      );
        if (null !== $this->getFrontPhoto()) {
            $trickData['photo'] = $this->getFrontPhoto()->getAdress();
        }

        return $trickData;
    }

    public function processTrickPhotos($uploadDir, $imageUploader)
    {
        foreach ($this->getTrickPhotos() as $photo) {
            if (null !== $photo->getAdress()) {
                $photo->add($imageUploader, $uploadDir);
                $photo->setTrick($this);
            } elseif (null === $photo->getAdress()) {
                $trick->removeTrickPhoto($photo);
            }
        }
    }

    public function processVideos()
    {
        foreach ($this->getVideos() as $video) {
            if (null !== $video->getIframe()) {
                $video->setTrick($this);
            } elseif (null === $video->getIframe()) {
                $this->removeVideo($video);
            }
        }
    }

    public function processTrick($uploadDir, $imageUploader, $trickPhotos = null, $videos = null)
    {
        $this->setUpdateDate(new \DateTime());

        $this->processTrickPhotos($uploadDir, $imageUploader);
        $photos = $this->getTrickPhotos();
        if (null !== $trickPhotos) {
            $this->setTrickPhotos($trickPhotos);
        }
        foreach ($photos as $photo) {
            $this->addTrickPhoto($photo);
        }
        $this->processVideos();
        $newVideos = $this->getVideos();
        if (null !== $videos) {
            $this->setVideos($videos);
        }
        foreach ($newVideos as $video) {
            $this->addVideo($video);
        }
    }
}
