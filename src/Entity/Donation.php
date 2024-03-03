<?php

namespace App\Entity;
use App\Repository\DonationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DonationRepository::class)]
class Donation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message:'champ obligatoire')]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z _-]+$/i', 
        message: 'le nom du produit ne contient pas des nombre',
        match: true
    )]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank (message:'champ obligatoire')]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'longeure insuffisante (min {{ limit }} caractères)',
        maxMessage: 'trop long ( limite atteinte({{ limit }})) ',
    )]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column]
    #[Assert\NotBlank (message:'champ obligatoire')]
    #[Assert\Positive]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_don = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message:'champ obligatoire')]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'donation', targetEntity: FeedbackDon::class)]
    private Collection $feedbackDons;

    #[ORM\ManyToOne(inversedBy: 'donations')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'donations')]
    private ?Panier $panier = null;

    public function __construct()
    {
        $this->feedbackDons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getDateDon(): ?\DateTimeInterface
    {
        return $this->date_don;
    }

    public function setDateDon(\DateTimeInterface $date_don): static
    {
        $this->date_don = $date_don;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, FeedbackDon>
     */
    public function getFeedbackDons(): Collection
    {
        return $this->feedbackDons;
    }

    public function addFeedbackDon(FeedbackDon $feedbackDon): static
    {
        if (!$this->feedbackDons->contains($feedbackDon)) {
            $this->feedbackDons->add($feedbackDon);
            $feedbackDon->setDonation($this);
        }

        return $this;
    }

    public function removeFeedbackDon(FeedbackDon $feedbackDon): static
    {
        if ($this->feedbackDons->removeElement($feedbackDon)) {
            // set the owning side to null (unless already changed)
            if ($feedbackDon->getDonation() === $this) {
                $feedbackDon->setDonation(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getPanier(): ?Panier
    {
        return $this->panier;
    }

    public function setPanier(?Panier $panier): static
    {
        $this->panier = $panier;

        return $this;
    }
    public function __toString()
    {
        return (string)$this->getName();
    }
}
