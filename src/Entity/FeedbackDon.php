<?php

namespace App\Entity;

use App\Repository\FeedbackDonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FeedbackDonRepository::class)]
class FeedbackDon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank (message:'champ obligatoire')]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'longeure insuffisante (min {{ limit }} caractères)',
        maxMessage: 'trop long ( limite atteinte({{ limit }})) ',
    )]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_feedback = null;

    #[ORM\ManyToOne(inversedBy: 'feedbackDons')]
    private ?Donation $donation = null;

    #[ORM\ManyToOne(inversedBy: 'feedbackDons')]
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
    
    public function __toString()
    {
        return (string)$this->getDescription();
    }
   
}
