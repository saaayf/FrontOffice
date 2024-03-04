<?php
// src/Entity/Recrutement.php

namespace App\Entity;

use App\Repository\RecrutementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecrutementRepository::class)]
class Recrutement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Title cannot be blank")]
    #[Assert\Length(max: 255, maxMessage: "Title cannot be longer than {{ limit }} characters")]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Description cannot be blank")]
    #[Assert\Length(max: 255, maxMessage: "Description cannot be longer than {{ limit }} characters")]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: "Creation date needs to be set")]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Status cannot be blank")]
    #[Assert\Length(max: 255, maxMessage: "Status cannot be longer than {{ limit }} characters")]
    private ?string $statut = null;

    #[ORM\OneToMany(targetEntity: Entretient::class, mappedBy: 'id_rec')]
    private Collection $entretients;

    public function __construct()
    {
        $this->entretients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;
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

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }

    /**
     * @return Collection<int, Entretient>
     */
    public function getEntretients(): Collection
    {
        return $this->entretients;
    }

    public function addEntretient(Entretient $entretient): self
    {
        if (!$this->entretients->contains($entretient)) {
            $this->entretients->add($entretient);
            $entretient->setIdRec($this);
        }

        return $this;
    }

    public function removeEntretient(Entretient $entretient): self
    {
        if ($this->entretients->removeElement($entretient)) {
            // set the owning side to null (unless already changed)
            if ($entretient->getIdRec() === $this) {
                $entretient->setIdRec(null);
            }
        }

        return $this;
    }
}
