<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlbumRepository::class)
 */
class Album
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
     * @ORM\Column(type="date", nullable=true)
     */
    private $release_date;

    /**
     * @ORM\ManyToMany(targetEntity=Artist::class, inversedBy="albums")
     */
    private $artists;

    /**
     * @ORM\OneToMany(targetEntity=Title::class, mappedBy="album",cascade={"persist"})
     */
    private $titles;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="albums")
     */
    private $category;

    public function __construct()
    {
        $this->artists = new ArrayCollection();
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

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(?\DateTimeInterface $release_date): self
    {
        $this->release_date = $release_date;

        return $this;
    }

    /**
     * @return Collection<int, Artist>
     */
    public function getArtists(): Collection
    {
        return $this->artists;
    }

    public function addArtist(Artist $artist): self
    {
        if (!$this->artists->contains($artist)) {
            $this->artists[] = $artist;
        }

        return $this;
    }

    public function removeArtist(Artist $artist): self
    {
        $this->artists->removeElement($artist);

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
            $title->setAlbum($this);
        }

        return $this;
    }

    public function removeTitle(Title $title): self
    {
        if ($this->titles->removeElement($title)) {
            // set the owning side to null (unless already changed)
            if ($title->getAlbum() === $this) {
                $title->setAlbum(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
