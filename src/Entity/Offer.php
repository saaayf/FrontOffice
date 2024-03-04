<?php
namespace App\Entity;
use App\Repository\OfferRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Validator\Constraints as CustomAssert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
#[ORM\HasLifecycleCallbacks()]

class Offer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Title cannot be blank")]
    #[Assert\Length(max: 255, maxMessage: "Title cannot be longer than 200 characters")]
    private $title;
    

    #[ORM\Column(type: "text")]
    #[Assert\NotBlank(message: "Description cannot be blank")]
    private $description;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Author cannot be blank")]
    #[Assert\Email(message: "Author must be with valid E-mail format")]
    private $author;

    
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: "Creation date needs to be set")]
    #[Assert\GreaterThan("today", message: "Created At cannot be in the Past")]
    private ?\DateTimeInterface $CreatedAt = null;

    
    #[ORM\ManyToOne(targetEntity: Motive::class)]
    #[ORM\JoinColumn(name: 'motive', referencedColumnName: 'motive')]
    #[Assert\NotNull(message: "Motive cannot be blank")]
    private ?Motive $motive;

    #[ORM\ManyToOne(targetEntity: Type::class)]
    #[ORM\JoinColumn(name: 'type', referencedColumnName: 'type')]
    #[Assert\NotNull(message: "type cannot be blank")]
    private ?Type $type;

    #[ORM\ManyToOne(targetEntity: Location::class)]
    #[ORM\JoinColumn(name: 'location', referencedColumnName: 'location')]
    #[Assert\NotNull(message: "Location cannot be blank")]
    private ?Location $location;

    #[ORM\ManyToOne(targetEntity: Status::class)]
    #[ORM\JoinColumn(name: 'status', referencedColumnName: 'status')]
    #[Assert\NotNull(message: "Status cannot be blank")]
    private ?Status $status = null;
    
    #[ORM\ManyToMany(targetEntity: Skill::class)]
    #[ORM\JoinTable(name: "offer_skills")]
    #[ORM\JoinColumn(name: "id", referencedColumnName: "id")]
    #[ORM\InverseJoinColumn(name: "skill", referencedColumnName: "skill")]
    private Collection $skills;

    #[Assert\File(
        maxSize: "5M",
        mimeTypes: ["image/jpeg", "image/png", "application/pdf"],
        mimeTypesMessage: "Please upload a valid image (JPEG or PNG) or PDF file"
    )]
    private ?UploadedFile $file = null;

    #[ORM\Column(nullable: true)]
    private ?string $fileName = null;

   // Getters and setters

   public function getId(): ?int
   {
       return $this->id;
   }

   public function getTitle(): ?string
   {
       return $this->title;
   }

   public function setTitle(string $title): self
   {
       $this->title = $title;

       return $this;
   }

   public function getAuthor(): ?string
   {
       return $this->author;
   }

   public function setAuthor(string $author): self
   {
       $this->author = $author;

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

// Getters and setters for associated entities
   public function getMotive(): ?Motive
   {
       return $this->motive;
   }

   public function setMotive(?Motive $motive): self
   {
       $this->motive = $motive;

       return $this;
   }

   public function getLocation(): ?Location
   {
       return $this->location;
   }

   public function setLocation(?Location $location): self
   {
       $this->location = $location;

       return $this;
   }

   public function getType(): ?Type
   {
       return $this->type;
   }

   public function setType(?Type $type): self
   {
       $this->type = $type;

       return $this;
   }

   public function getStatus(): ?Status
   {
       return $this->status;
   }

   public function setStatus(?Status $status): self
   {
       $this->status = $status;

       return $this;
   }


   public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt($CreatedAt): static
    {
        if (is_string($CreatedAt)) {
            $CreatedAt = new \DateTime($CreatedAt);
        } elseif (!$CreatedAt instanceof \DateTimeInterface) {
            $CreatedAt = null;
        }
        $this->CreatedAt = $CreatedAt;
        return $this;
    }


    public function __construct()
    {
        $this->skills = new ArrayCollection();
    }

    // Getter and setter methods for $skills...

    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function setSkills(Collection $skills): self
    {
        $this->skills = $skills;

        return $this;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        $this->skills->removeElement($skill);

        return $this;
    }
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    public function setFile(?UploadedFile $file): self
    {
        $this->file = $file;
        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName;
        return $this;
    }
}
      
