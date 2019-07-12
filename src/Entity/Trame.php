<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrameRepository")
 */
class Trame
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
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $orga;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $matos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stb", mappedBy="trame", orphanRemoval=true, cascade={"persist"})
     */
    private $stbs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GNEvent", inversedBy="trames")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gnevent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $locked;



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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getOrga(): ?string
    {
        return $this->orga;
    }

    public function setOrga(string $orga): self
    {
        $this->orga = $orga;

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

    public function getMatos(): ?string
    {
        return $this->matos;
    }

    public function setMatos(?string $matos): self
    {
        $this->matos = $matos;

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
            $stb->setTrame($this);
        }

        return $this;
    }

    public function removeStb(Stb $stb): self
    {
        if ($this->stbs->contains($stb)) {
            $this->stbs->removeElement($stb);
            // set the owning side to null (unless already changed)
            if ($stb->getTrame() === $this) {
                $stb->setTrame(null);
            }
        }

        return $this;
    }

    public function getGnevent(): ?GNEvent
    {
        return $this->gnevent;
    }

    public function setGnevent(?GNEvent $gnevent): self
    {
        $this->gnevent = $gnevent;

        return $this;
    }

    public function getLocked(): ?string
    {
        return $this->locked;
    }

    public function setLocked(?string $locked): self
    {
        $this->locked = $locked;

        return $this;
    }


}
