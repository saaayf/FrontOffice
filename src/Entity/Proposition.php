<?php

namespace App\Entity;

use App\Repository\PropositionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PropositionRepository::class)]
class Proposition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $prop_budget = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $prop_delai = null;

    #[ORM\ManyToOne(inversedBy: 'propList')]
    #[ORM\JoinColumn(nullable: false , onDelete : "CASCADE" )]
    private ?Projet $id_projet = null;

     #[ORM\ManyToOne(targetEntity: User::class)]
            #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
            private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPropBudget(): ?float
    {
        return $this->prop_budget;
    }

    public function setPropBudget(float $prop_budget): static
    {
        $this->prop_budget = $prop_budget;

        return $this;
    }

    public function getPropDelai(): ?\DateTimeInterface
    {
        return $this->prop_delai;
    }

    public function setPropDelai(\DateTimeInterface $prop_delai): static
    {
        $this->prop_delai = $prop_delai;

        return $this;
    }

    public function getIdProjet(): ?projet
    {
        return $this->id_projet;
    }

    public function setIdProjet(?projet $id_projet): static
    {
        $this->id_projet = $id_projet;

        return $this;
    }


    public function getUser(): ?User
            {
                return $this->user;
            }

            public function setUser(?User $user): self
            {
                $this->user = $user;
                return $this;
            }
}
