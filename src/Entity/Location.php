<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\Column(length: 50)] // Change the type and length to match the primary key
    private ?string $location = null; // Change the type to string and make it nullable

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: Offer::class)]
    private Collection $offers;

    public function __construct()
    {
        $this->offers = new ArrayCollection();
    }


    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

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
            // Check if the Offer's locationEntity is the same as the current Location entity
            if ($offer->getLocation() === $this) {
                // Set the Offer's locationEntity to null
                $offer->setLocation(null);
            }
        }
    
        return $this;
    }
    
    public function __toString(){
        return $this->getLocation();
    }
}
