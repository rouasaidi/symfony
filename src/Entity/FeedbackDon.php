<?php

namespace App\Entity;

use App\Repository\FeedbackDonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeedbackDonRepository::class)]
class FeedbackDon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_feedback = null;

    #[ORM\ManyToOne(inversedBy: 'feedbackdons')]
    private ?Donation $donation = null;

    #[ORM\ManyToOne(inversedBy: 'feedbackdons')]
    private ?User $user = null;

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

    public function getDateFeedback(): ?\DateTimeInterface
    {
        return $this->date_feedback;
    }

    public function setDateFeedback(\DateTimeInterface $date_feedback): static
    {
        $this->date_feedback = $date_feedback;

        return $this;
    }

    public function getDonation(): ?Donation
    {
        return $this->donation;
    }

    public function setDonation(?Donation $donation): static
    {
        $this->donation = $donation;

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
