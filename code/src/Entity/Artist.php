<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArtistRepository::class)
 */
class Artist
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $real_name;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birth_date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $summary;

    /**
     * @ORM\ManyToMany(targetEntity=Album::class, mappedBy="artists")
     */
    private $albums;

    /**
     * @ORM\ManyToMany(targetEntity=Title::class, mappedBy="feats")
     */
    private $titles;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
        $this->titles = new ArrayCollection();
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

    public function getRealName(): ?string
    {
        return $this->real_name;
    }

    public function setRealName(?string $real_name): self
    {
        $this->real_name = $real_name;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birth_date;
    }

    public function setBirthDate(?\DateTimeInterface $birth_date): self
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * @return Collection<int, Album>
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums[] = $album;
            $album->addArtist($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
    {
        if ($this->albums->removeElement($album)) {
            $album->removeArtist($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Title>
     */
    public function getTitles(): Collection
    {
        return $this->titles;
    }

    public function addTitle(Title $title): self
    {
        if (!$this->titles->contains($title)) {
            $this->titles[] = $title;
            $title->addFeat($this);
        }

        return $this;
    }

    public function removeTitle(Title $title): self
    {
        if ($this->titles->removeElement($title)) {
            $title->removeFeat($this);
        }

        return $this;
    }
}
