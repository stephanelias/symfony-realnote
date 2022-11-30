<?php

namespace App\Entity;

use App\Repository\TitleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass=TitleRepository::class)
 */
class Title
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Album::class, inversedBy="titles",cascade={"persist", "remove"})
     * @JoinColumn(onDelete="CASCADE")
     */
    private $album;

    /**
     * @ORM\ManyToMany(targetEntity=Artist::class, inversedBy="titles")
     */
    private $feats;

    public function __construct()
    {
        $this->feats = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    /**
     * @return Collection<int, Artist>
     */
    public function getFeats(): Collection
    {
        return $this->feats;
    }

    public function addFeat(Artist $feat): self
    {
        if (!$this->feats->contains($feat)) {
            $this->feats[] = $feat;
        }

        return $this;
    }

    public function removeFeat(Artist $feat): self
    {
        $this->feats->removeElement($feat);

        return $this;
    }
}
