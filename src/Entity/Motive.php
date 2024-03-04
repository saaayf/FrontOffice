<?php

namespace App\Entity;

use App\Repository\MotiveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MotiveRepository::class)]
class Motive
{
    #[ORM\Id]
    #[ORM\Column(length: 50)] // Change the type and length to match the primary key
    private ?string $motive = null; // Change the type to string and make it nullable

    #[ORM\OneToMany(mappedBy: 'motive', targetEntity: Offer::class)]
    private Collection $offers;

    public function __construct()
    {
        $this->offers = new ArrayCollection();
    }



    public function getMotive(): ?string
    {
        return $this->motive;
    }

    public function setMotive(string $motive): static
    {
        $this->motive = $motive;

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
            if ($offer->getMotive() === $this) {
                $offer->setMotive(null);
            }
        }
    
        return $this;
    }
    
    public function __toString(){
        return $this->getMotive();
    }
}
