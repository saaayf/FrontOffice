<?php
// src/Entity/Entretient.php

namespace App\Entity;

use App\Repository\EntretientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EntretientRepository::class)]
class Entretient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: "Creation date needs to be set")]
    #[Assert\GreaterThanOrEqual("today", message: "Date cannot be in the past")]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Type cannot be blank")]
    #[Assert\Type("string", message: "Type must be a string")]
    #[Assert\Regex(pattern: '/^[a-zA-Z\s]+$/', message: "Type can only contain letters and spaces")]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Resultat cannot be blank")]
    #[Assert\Type("string", message: "Resultat must be a string")]
    #[Assert\Regex(pattern: '/^[a-zA-Z\s]+$/', message: "Resultat can only contain letters and spaces")]
    private ?string $resultat = null;

    #[ORM\ManyToOne(inversedBy: 'entretients')]
    private ?Recrutement $id_rec = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getResultat(): ?string
    {
        return $this->resultat;
    }

    public function setResultat(string $resultat): self
    {
        $this->resultat = $resultat;
        return $this;
    }

    public function getIdRec(): ?Recrutement
    {
        return $this->id_rec;
    }

    public function setIdRec(?Recrutement $id_rec): self
    {
        $this->id_rec = $id_rec;
        return $this;
    }
}
