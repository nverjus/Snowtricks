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
     * @Assert\NotBlank(message = "The trick must have a namespace")
     * @Assert\Length(min = 4,
     *               minMessage = "The name must have at least 4 characters",
     *               max = 25,
     *               maxMessage = "The name can't have more than 50 characters"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message = "The trick must have a namespace")
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
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="trick", orphanRemoval=true)
     */
    private $comments;

    /**
    * @ORM\OneToMany(targetEntity="App\Entity\TrickPhoto", mappedBy="trick", cascade={"persist", "remove"})
     */
    private $trickPhotos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Video", mappedBy="trick", cascade={"persist", "remove"})
     */
    private $videos;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\TrickPhoto", cascade={"persist", "remove"})
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
            if ($comment->getTrick() === $this) {
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
        }

        return $this;
    }

    public function removeTrickPhoto(TrickPhoto $trickPhoto): self
    {
        if ($this->trickPhotos->contains($trickPhoto)) {
            $this->trickPhotos->removeElement($trickPhoto);
            // set the owning side to null (unless already changed)
            if ($trickPhoto->getTrick() === $this) {
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
        $this->trickPhotos = new ArrayCollection();
        return $this;
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
        $this->videos = new ArrayCollection();
        return $this;
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

    public function setFrontPhoto(?TrickPhoto $frontPhoto): self
    {
        $this->frontPhoto = $frontPhoto;
        $this->frontPhoto->setTrick($this);

        return $this;
    }
}
