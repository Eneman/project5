<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GNEventRepository")
 */
class GNEvent
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trame", mappedBy="gnevent", orphanRemoval=true)
     */
    private $trames;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $locked;



    public function __construct()
    {
        $this->trames = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection|Trame[]
     */
    public function getTrames(): Collection
    {
        return $this->trames;
    }

    public function addTrame(Trame $trame): self
    {
        if (!$this->trames->contains($trame)) {
            $this->trames[] = $trame;
            $trame->setGnevent($this);
        }

        return $this;
    }

    public function removeTrame(Trame $trame): self
    {
        if ($this->trames->contains($trame)) {
            $this->trames->removeElement($trame);
            // set the owning side to null (unless already changed)
            if ($trame->getGnevent() === $this) {
                $trame->setGnevent(null);
            }
        }

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
