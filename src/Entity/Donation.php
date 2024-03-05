<?php

namespace App\Entity;

use App\Repository\DonationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonationRepository::class)]
class Donation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $categorie = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_don = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'donation', targetEntity: Feedbackdon::class)]
    private Collection $feedbackdons;

    #[ORM\ManyToOne(inversedBy: 'donations')]
    private ?User $user = null;

    public function __construct()
    {
        $this->feedbackdons = new ArrayCollection();
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

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

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
     * @return Collection<int, Feedbackdon>
     */
    public function getFeedbackdons(): Collection
    {
        return $this->feedbackdons;
    }

    public function addFeedbackdon(Feedbackdon $feedbackdon): static
    {
        if (!$this->feedbackdons->contains($feedbackdon)) {
            $this->feedbackdons->add($feedbackdon);
            $feedbackdon->setDonation($this);
        }

        return $this;
    }

    public function removeFeedbackdon(Feedbackdon $feedbackdon): static
    {
        if ($this->feedbackdons->removeElement($feedbackdon)) {
            // set the owning side to null (unless already changed)
            if ($feedbackdon->getDonation() === $this) {
                $feedbackdon->setDonation(null);
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
}
