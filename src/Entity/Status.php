<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\Column(length: 50)] // Change the type and length to match the primary key
    private ?string $status = null; // Change the type to string and make it nullable

    #[ORM\OneToMany(mappedBy: 'status', targetEntity: Offer::class)]
    private Collection $offers;

    public function __construct()
    {
        $this->offers = new ArrayCollection();
    }


    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Offer>
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): static
    {
        if (!$this->offers->contains($offer)) {
            $this->offers->add($offer);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): static
    {
        if ($this->offers->removeElement($offer)) {
            // Check if the Offer's statusEntity is the same as the current Status entity
            if ($offer->getStatus() === $this) {
                // Set the Offer's statusEntity to null
                $offer->setStatus(null);
            }
        }
    
        return $this;
    }
    
    public function __toString(){
        return $this->getStatus();
    }
}

