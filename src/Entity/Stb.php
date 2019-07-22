<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StbRepository")
 */
class Stb
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trame", inversedBy="stbs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trame;

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

    public function getCharacters(): ?array
    {
        return $this->characters;
    }

    public function setCharacters(array $characters): self
    {
        $this->characters = $characters;

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

    public function getTrame(): ?Trame
    {
        return $this->trame;
    }

    public function setTrame(?Trame $trame): self
    {
        $this->trame = $trame;

        return $this;
    }
}
