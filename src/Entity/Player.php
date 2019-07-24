<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 */
class Player
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Stb", mappedBy="players")
     */
    private $stbs;

    public function __construct()
    {
        $this->stbs = new ArrayCollection();
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

    /**
     * @return Collection|Stb[]
     */
    public function getStbs(): Collection
    {
        return $this->stbs;
    }

    public function addStb(Stb $stb): self
    {
        if (!$this->stbs->contains($stb)) {
            $this->stbs[] = $stb;
            $stb->addPlayer($this);
        }

        return $this;
    }

    public function removeStb(Stb $stb): self
    {
        if ($this->stbs->contains($stb)) {
            $this->stbs->removeElement($stb);
            $stb->removePlayer($this);
        }

        return $this;
    }
}
